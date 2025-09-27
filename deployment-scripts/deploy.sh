#!/bin/bash

# MSK COMPUTERS Deployment Script
# Usage: ./deploy.sh [environment]
# Example: ./deploy.sh production

set -e  # Exit on any error

# Configuration
PROJECT_NAME="MSK COMPUTERS"
DOMAIN="mskcomputers.lk"
PROJECT_DIR="/var/www/${DOMAIN}"
BACKUP_DIR="/var/backups/mskcomputers"
DB_NAME="mskcomputers_db"
DB_USER="mskcomputers_user"
ENVIRONMENT=${1:-production}

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Logging function
log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')] $1${NC}"
}

warning() {
    echo -e "${YELLOW}[WARNING] $1${NC}"
}

error() {
    echo -e "${RED}[ERROR] $1${NC}"
    exit 1
}

info() {
    echo -e "${BLUE}[INFO] $1${NC}"
}

# Check if running as correct user
check_user() {
    if [[ $EUID -eq 0 ]]; then
        error "This script should not be run as root for security reasons"
    fi
}

# Check prerequisites
check_prerequisites() {
    log "Checking prerequisites..."
    
    # Check if required commands exist
    command -v php >/dev/null 2>&1 || error "PHP is not installed"
    command -v composer >/dev/null 2>&1 || error "Composer is not installed"
    command -v npm >/dev/null 2>&1 || error "NPM is not installed"
    command -v mysql >/dev/null 2>&1 || error "MySQL client is not installed"
    
    # Check PHP version
    PHP_VERSION=$(php -v | head -n 1 | cut -d " " -f 2 | cut -d "." -f 1,2)
    if [[ $(echo "$PHP_VERSION < 8.1" | bc) -eq 1 ]]; then
        error "PHP version must be 8.1 or higher. Current version: $PHP_VERSION"
    fi
    
    info "Prerequisites check passed ✓"
}

# Create backup before deployment
create_backup() {
    log "Creating backup before deployment..."
    
    # Create backup directory
    sudo mkdir -p "$BACKUP_DIR"
    sudo chown $USER:$USER "$BACKUP_DIR"
    
    DATE=$(date +%Y%m%d_%H%M%S)
    
    # Backup database
    if [[ -f "$PROJECT_DIR/.env" ]]; then
        info "Backing up database..."
        DB_PASSWORD=$(grep DB_PASSWORD "$PROJECT_DIR/.env" | cut -d '=' -f2 | tr -d '"')
        mysqldump -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" > "$BACKUP_DIR/database_${DATE}.sql"
        
        # Backup application files
        info "Backing up application files..."
        tar -czf "$BACKUP_DIR/files_${DATE}.tar.gz" -C "$(dirname $PROJECT_DIR)" "$(basename $PROJECT_DIR)" \
            --exclude='node_modules' \
            --exclude='vendor' \
            --exclude='storage/logs/*' \
            --exclude='storage/framework/cache/*' \
            --exclude='storage/framework/sessions/*' \
            --exclude='storage/framework/views/*'
        
        info "Backup created successfully ✓"
    else
        warning "No existing .env file found, skipping backup"
    fi
}

# Put application in maintenance mode
enable_maintenance() {
    log "Enabling maintenance mode..."
    if [[ -f "$PROJECT_DIR/artisan" ]]; then
        cd "$PROJECT_DIR"
        php artisan down --retry=60 --secret="msk-maintenance-2024" || warning "Could not enable maintenance mode"
    fi
}

# Disable maintenance mode
disable_maintenance() {
    log "Disabling maintenance mode..."
    if [[ -f "$PROJECT_DIR/artisan" ]]; then
        cd "$PROJECT_DIR"
        php artisan up || warning "Could not disable maintenance mode"
    fi
}

# Install/Update dependencies
install_dependencies() {
    log "Installing/updating dependencies..."
    
    cd "$PROJECT_DIR"
    
    # Install Composer dependencies
    info "Installing Composer dependencies..."
    composer install --optimize-autoloader --no-dev --no-interaction
    
    # Install NPM dependencies and build assets
    info "Installing NPM dependencies..."
    npm ci --production
    
    info "Building production assets..."
    npm run build
    
    info "Dependencies installed successfully ✓"
}

# Run database migrations
run_migrations() {
    log "Running database migrations..."
    
    cd "$PROJECT_DIR"
    
    # Run migrations
    php artisan migrate --force
    
    # Seed database if specified
    if [[ "$2" == "--seed" ]]; then
        info "Seeding database..."
        php artisan db:seed --force
    fi
    
    info "Database migrations completed ✓"
}

# Clear and cache application
optimize_application() {
    log "Optimizing application..."
    
    cd "$PROJECT_DIR"
    
    # Clear all caches
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    
    # Cache for production
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
    
    info "Application optimized ✓"
}

# Set proper permissions
set_permissions() {
    log "Setting proper file permissions..."
    
    # Set ownership
    sudo chown -R www-data:www-data "$PROJECT_DIR"
    
    # Set directory permissions
    sudo find "$PROJECT_DIR" -type d -exec chmod 755 {} \;
    
    # Set file permissions
    sudo find "$PROJECT_DIR" -type f -exec chmod 644 {} \;
    
    # Set executable permissions for artisan
    sudo chmod +x "$PROJECT_DIR/artisan"
    
    # Set writable permissions for Laravel directories
    sudo chmod -R 775 "$PROJECT_DIR/storage"
    sudo chmod -R 775 "$PROJECT_DIR/bootstrap/cache"
    
    # Secure .env file
    sudo chmod 600 "$PROJECT_DIR/.env"
    
    info "File permissions set ✓"
}

# Test application
test_application() {
    log "Testing application..."
    
    cd "$PROJECT_DIR"
    
    # Test database connection
    info "Testing database connection..."
    php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connection successful\n';"
    
    # Test configuration
    info "Testing configuration..."
    php artisan config:show app.env app.debug app.url
    
    # Test routes
    info "Testing routes..."
    php artisan route:list --compact | head -10
    
    info "Application tests passed ✓"
}

# Restart web services
restart_services() {
    log "Restarting web services..."
    
    # Restart PHP-FPM
    sudo systemctl restart php8.1-fpm
    
    # Restart web server (detect which one is running)
    if systemctl is-active --quiet nginx; then
        sudo systemctl restart nginx
        info "Nginx restarted ✓"
    elif systemctl is-active --quiet apache2; then
        sudo systemctl restart apache2
        info "Apache restarted ✓"
    else
        warning "No recognized web server found to restart"
    fi
}

# Cleanup old files
cleanup() {
    log "Cleaning up..."
    
    cd "$PROJECT_DIR"
    
    # Remove old logs (older than 30 days)
    find storage/logs/ -name "*.log" -mtime +30 -delete 2>/dev/null || true
    
    # Clean npm cache
    npm cache clean --force 2>/dev/null || true
    
    # Clean composer cache
    composer clear-cache 2>/dev/null || true
    
    # Remove old backups (keep last 7 days)
    find "$BACKUP_DIR" -name "*.sql" -mtime +7 -delete 2>/dev/null || true
    find "$BACKUP_DIR" -name "*.tar.gz" -mtime +7 -delete 2>/dev/null || true
    
    info "Cleanup completed ✓"
}

# Main deployment function
deploy() {
    log "Starting deployment of $PROJECT_NAME to $ENVIRONMENT environment..."
    
    # Pre-deployment checks
    check_user
    check_prerequisites
    
    # Create backup
    create_backup
    
    # Enable maintenance mode
    enable_maintenance
    
    # Deployment steps
    install_dependencies
    run_migrations
    optimize_application
    set_permissions
    
    # Post-deployment
    restart_services
    disable_maintenance
    test_application
    cleanup
    
    log "Deployment completed successfully! 🎉"
    info "Website: https://$DOMAIN"
    info "Admin: https://$DOMAIN/admin"
}

# Rollback function
rollback() {
    log "Rolling back deployment..."
    
    enable_maintenance
    
    # Find latest backup
    LATEST_DB_BACKUP=$(ls -t "$BACKUP_DIR"/database_*.sql 2>/dev/null | head -1)
    LATEST_FILE_BACKUP=$(ls -t "$BACKUP_DIR"/files_*.tar.gz 2>/dev/null | head -1)
    
    if [[ -z "$LATEST_DB_BACKUP" || -z "$LATEST_FILE_BACKUP" ]]; then
        error "No backup files found for rollback"
    fi
    
    # Restore database
    info "Restoring database from: $LATEST_DB_BACKUP"
    DB_PASSWORD=$(grep DB_PASSWORD "$PROJECT_DIR/.env" | cut -d '=' -f2 | tr -d '"')
    mysql -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" < "$LATEST_DB_BACKUP"
    
    # Restore files
    info "Restoring files from: $LATEST_FILE_BACKUP"
    cd "$(dirname $PROJECT_DIR)"
    tar -xzf "$LATEST_FILE_BACKUP"
    
    # Re-optimize
    cd "$PROJECT_DIR"
    optimize_application
    set_permissions
    restart_services
    disable_maintenance
    
    log "Rollback completed successfully!"
}

# Help function
show_help() {
    echo "MSK COMPUTERS Deployment Script"
    echo ""
    echo "Usage: $0 [command] [options]"
    echo ""
    echo "Commands:"
    echo "  deploy [env]     Deploy application (default: production)"
    echo "  rollback         Rollback to previous version"
    echo "  backup           Create backup only"
    echo "  test             Test application"
    echo "  maintenance on   Enable maintenance mode"
    echo "  maintenance off  Disable maintenance mode"
    echo "  help             Show this help message"
    echo ""
    echo "Options:"
    echo "  --seed           Seed database after migration"
    echo ""
    echo "Examples:"
    echo "  $0 deploy production"
    echo "  $0 deploy production --seed"
    echo "  $0 rollback"
    echo "  $0 backup"
    echo ""
}

# Parse command line arguments
case "${1:-deploy}" in
    deploy)
        deploy
        ;;
    rollback)
        rollback
        ;;
    backup)
        create_backup
        ;;
    test)
        test_application
        ;;
    maintenance)
        case "$2" in
            on)
                enable_maintenance
                ;;
            off)
                disable_maintenance
                ;;
            *)
                error "Usage: $0 maintenance [on|off]"
                ;;
        esac
        ;;
    help|--help|-h)
        show_help
        ;;
    *)
        error "Unknown command: $1. Use '$0 help' for usage information."
        ;;
esac
