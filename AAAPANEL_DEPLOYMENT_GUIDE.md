# MSK Computers - aaaPanel Deployment Guide (No Terminal)

## 📋 Prerequisites
- aaaPanel server with PHP 8.1+ installed
- MySQL database access
- Domain name pointed to your server
- FTP/File Manager access

## 🚀 Step-by-Step Deployment

### 1. Prepare Your Local Files

**Create deployment package:**
1. Download your project as ZIP or prepare all files
2. Make sure `.env` file has production settings
3. Ensure `storage` and `bootstrap/cache` folders exist

### 2. aaaPanel Website Setup

**Create Website:**
1. Login to aaaPanel
2. Go to **Website** → **Add Site**
3. Enter your domain name
4. Select PHP 8.1 or higher
5. Choose **Laravel** template if available
6. Create the site

### 3. Upload Application Files

**Using File Manager:**
1. Go to **Files** in aaaPanel
2. Navigate to your website folder (`/www/wwwroot/yourdomain.com/`)
3. Delete default files (index.html, etc.)
4. Upload your Laravel files:
   - Either upload ZIP file and extract
   - Or upload files/folders individually
5. Make sure all Laravel folders are present:
   - `app/`, `config/`, `database/`, `public/`, `resources/`, `routes/`, `storage/`, `vendor/`

### 4. Set Document Root

**Configure Web Root:**
1. In aaaPanel, go to **Website** → **Settings**
2. Click on your domain
3. Go to **Website Directory**
4. Set **Site Directory** to: `/www/wwwroot/yourdomain.com/public`
5. Save changes

### 5. Database Setup

**Create Database:**
1. Go to **Database** in aaaPanel
2. Click **Add Database**
3. Database name: `msk_computers`
4. Username: `msk_user` (or your choice)
5. Generate/set strong password
6. Save database credentials

**Create Products Database:**
1. Create second database: `msk_computers_products`
2. Use same username or create new one
3. Save credentials

### 6. Environment Configuration

**Edit .env file:**
1. In File Manager, navigate to your site root
2. Edit `.env` file
3. Update these settings:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=msk_computers
DB_USERNAME=msk_user
DB_PASSWORD=your_database_password

PRODUCTS_DB_HOST=localhost
PRODUCTS_DB_PORT=3306
PRODUCTS_DB_DATABASE=msk_computers_products
PRODUCTS_DB_USERNAME=msk_user
PRODUCTS_DB_PASSWORD=your_database_password
```

### 7. Install Dependencies (No Terminal Method)

**Option A: Upload vendor folder**
1. Run `composer install` locally
2. Upload the entire `vendor/` folder via File Manager

**Option B: Use Composer through aaaPanel**
1. Check if aaaPanel has **Composer** in **PHP Manager**
2. If available, run composer install through web interface

### 8. Set Folder Permissions

**Using File Manager:**
1. Right-click on `storage/` folder
2. Set permissions to `755` or `775`
3. Right-click on `bootstrap/cache/` folder  
4. Set permissions to `755` or `775`

### 9. Generate Application Key

**Manual Key Generation:**
1. Go to https://generate-random.org/laravel-key-generator
2. Generate a new key
3. Copy the key (starts with `base64:`)
4. Edit `.env` file and set: `APP_KEY=base64:your_generated_key`

### 10. SSL Certificate

**Enable HTTPS:**
1. In aaaPanel, go to **Website** → **Settings**
2. Click on your domain
3. Go to **SSL** tab
4. Choose **Let's Encrypt** for free SSL
5. Generate and install certificate
6. Enable **Force HTTPS**

### 11. Database Migration (Manual)

**Import Database:**
1. Export your local database to SQL file
2. In aaaPanel, go to **Database** → **phpMyAdmin**
3. Select your database
4. Import SQL file
5. Repeat for products database if needed

### 12. URL Rewriting

**Configure .htaccess:**
Make sure your `public/.htaccess` file contains:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 13. Test Installation

**Verify Setup:**
1. Visit your domain
2. Check if Laravel welcome page loads
3. Test database connections
4. Verify file uploads work
5. Check admin panel access

## 🔧 Troubleshooting

### Common Issues:

**500 Error:**
- Check folder permissions
- Verify .env configuration
- Check PHP version compatibility

**Database Connection:**
- Verify database credentials
- Check if databases exist
- Ensure user has proper permissions

**File Upload Issues:**
- Check `storage/` permissions
- Verify `upload_max_filesize` in PHP settings

**Performance:**
- Enable OPcache in PHP settings
- Set appropriate memory limits

## 📁 File Structure Check

Ensure these folders exist with correct permissions:
```
/www/wwwroot/yourdomain.com/
├── app/
├── bootstrap/cache/ (755)
├── config/
├── database/
├── public/ (document root)
├── resources/
├── routes/
├── storage/ (755)
├── vendor/
├── .env
└── composer.json
```

## 🎯 Final Steps

1. **Clear Cache:** Delete files in `bootstrap/cache/` if any
2. **Test All Features:** Orders, payments, admin panel
3. **Setup Monitoring:** Enable error logging in aaaPanel
4. **Backup:** Setup regular backups in aaaPanel

## 📞 Support

If you encounter issues:
1. Check aaaPanel error logs
2. Enable Laravel debug mode temporarily
3. Verify all file permissions
4. Check PHP error logs

Your MSK Computers website should now be live on aaaPanel! 🚀
