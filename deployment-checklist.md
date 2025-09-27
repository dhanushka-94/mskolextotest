# MSK COMPUTERS - Deployment Checklist ✅

## 📋 Complete Deployment Checklist for mskcomputers.lk

### 🔧 Pre-Deployment Setup

#### Domain & Hosting
- [ ] **Domain purchased**: mskcomputers.lk
- [ ] **DNS configured**: A records pointing to server IP
- [ ] **Hosting provider selected**: VPS/Cloud hosting recommended
- [ ] **Server specs verified**: PHP 8.1+, MySQL 5.7+, sufficient storage
- [ ] **SSH access confirmed**: Can connect to server

#### Server Environment
- [ ] **Web server installed**: Nginx (recommended) or Apache
- [ ] **PHP 8.1+ installed**: With required extensions
- [ ] **MySQL/MariaDB installed**: Database server running
- [ ] **Composer installed**: For dependency management
- [ ] **Node.js & NPM installed**: For asset compilation
- [ ] **Git installed**: For version control

#### PHP Extensions Check
- [ ] BCMath extension
- [ ] Ctype extension  
- [ ] Fileinfo extension
- [ ] JSON extension
- [ ] Mbstring extension
- [ ] OpenSSL extension
- [ ] PDO extension
- [ ] Tokenizer extension
- [ ] XML extension
- [ ] GD or Imagick extension

### 📁 Project Preparation

#### Local Development
- [ ] **All features tested**: Cart, admin panel, forms working
- [ ] **Database seeded**: Sample data populated
- [ ] **Assets compiled**: `npm run build` completed
- [ ] **Dependencies optimized**: `composer install --optimize-autoloader --no-dev`
- [ ] **Caches cleared**: All Laravel caches cleared
- [ ] **Environment variables checked**: .env.example updated

#### Code Quality
- [ ] **No debug code**: Remove dd(), dump(), console.log()
- [ ] **Error handling**: Proper try-catch blocks
- [ ] **Security reviewed**: No hardcoded credentials
- [ ] **Performance optimized**: Queries optimized, caching implemented

### 🚀 Deployment Process

#### File Upload
- [ ] **Project files uploaded**: Via FTP, SFTP, or Git clone
- [ ] **Permissions set**: 755 for directories, 644 for files
- [ ] **Storage writable**: 775 permissions for storage and bootstrap/cache
- [ ] **Web root configured**: Public folder as document root

#### Environment Configuration
- [ ] **Production .env created**: Based on .env.example
- [ ] **App key generated**: `php artisan key:generate`
- [ ] **Debug mode disabled**: `APP_DEBUG=false`
- [ ] **Production URL set**: `APP_URL=https://mskcomputers.lk`
- [ ] **Timezone configured**: `APP_TIMEZONE="Asia/Colombo"`
- [ ] **Database credentials set**: Correct host, username, password
- [ ] **Mail configuration**: SMTP settings for contact forms

#### Database Setup
- [ ] **Database created**: mskcomputers_db or similar
- [ ] **User created**: Dedicated database user with proper privileges
- [ ] **Migrations run**: `php artisan migrate --force`
- [ ] **Data seeded**: `php artisan db:seed --force`
- [ ] **Connection tested**: Database accessible from application

#### Dependencies & Optimization
- [ ] **Composer install**: `composer install --optimize-autoloader --no-dev`
- [ ] **Config cached**: `php artisan config:cache`
- [ ] **Routes cached**: `php artisan route:cache` 
- [ ] **Views cached**: `php artisan view:cache`
- [ ] **Events cached**: `php artisan event:cache`

### 🌐 Web Server Configuration

#### Nginx Setup
- [ ] **Server block created**: /etc/nginx/sites-available/mskcomputers.lk
- [ ] **SSL configured**: HTTPS redirect and security headers
- [ ] **Gzip compression enabled**: For faster loading
- [ ] **Cache headers set**: Static asset caching
- [ ] **Security headers added**: XSS protection, HSTS, etc.
- [ ] **Site enabled**: Symlink to sites-enabled
- [ ] **Configuration tested**: `nginx -t` passes
- [ ] **Nginx reloaded**: `systemctl reload nginx`

#### Apache Setup (if using Apache)
- [ ] **Virtual host created**: .conf file in sites-available
- [ ] **SSL configured**: HTTPS redirect and certificates
- [ ] **Mod_rewrite enabled**: For Laravel routing
- [ ] **Security headers added**: Via mod_headers
- [ ] **Site enabled**: `a2ensite mskcomputers.lk`
- [ ] **Apache reloaded**: `systemctl reload apache2`

### 🔒 SSL Certificate

#### Let's Encrypt Setup
- [ ] **Certbot installed**: SSL certificate tool
- [ ] **Certificate obtained**: For mskcomputers.lk and www.mskcomputers.lk
- [ ] **Auto-renewal configured**: Cron job or systemd timer
- [ ] **HTTPS redirect working**: HTTP automatically redirects to HTTPS
- [ ] **SSL grade verified**: A+ rating on SSL Labs test

### 🔧 Security Configuration

#### Server Security
- [ ] **Firewall configured**: UFW or iptables rules
- [ ] **SSH secured**: Key-based authentication, port changed
- [ ] **Fail2ban installed**: Protection against brute force
- [ ] **Software updated**: OS and all packages current
- [ ] **Unused services disabled**: Minimize attack surface

#### Application Security
- [ ] **Environment file secured**: 600 permissions on .env
- [ ] **Admin routes protected**: Strong authentication
- [ ] **SQL injection prevented**: Prepared statements used
- [ ] **XSS protection enabled**: Input validation and output escaping
- [ ] **CSRF protection active**: Laravel CSRF tokens working

### 📊 Performance Optimization

#### Server Performance
- [ ] **PHP OPcache enabled**: Bytecode caching active
- [ ] **Database optimized**: Indexes created, queries tuned
- [ ] **Memory limits set**: Adequate PHP memory_limit
- [ ] **File uploads configured**: Max file size for product images

#### Application Performance
- [ ] **Laravel caching enabled**: Config, routes, views cached
- [ ] **Database queries optimized**: N+1 queries eliminated
- [ ] **Images optimized**: Compressed and properly sized
- [ ] **CDN configured**: (Optional) For static assets

### 🧪 Testing & Verification

#### Functionality Testing
- [ ] **Homepage loads**: Main page accessible
- [ ] **Navigation works**: All menu links functional
- [ ] **Product pages load**: Category and product detail pages
- [ ] **Cart functionality**: Add, remove, update items
- [ ] **Checkout process**: Complete order flow
- [ ] **Admin panel access**: Dashboard login and features
- [ ] **Forms working**: Contact forms send emails
- [ ] **Search function**: Product search returns results

#### Performance Testing
- [ ] **Page speed tested**: <3 seconds load time
- [ ] **Mobile responsive**: Works on all device sizes
- [ ] **Cross-browser tested**: Chrome, Firefox, Safari, Edge
- [ ] **Load testing**: Can handle concurrent users

#### SEO & Analytics
- [ ] **Sitemap accessible**: /sitemap.xml loads
- [ ] **Robots.txt configured**: /robots.txt allows search engines
- [ ] **Meta tags present**: Title, description on all pages
- [ ] **Google Analytics added**: Tracking code installed
- [ ] **Search Console verified**: Domain ownership confirmed

### 📧 Email & Communication

#### Email Configuration
- [ ] **SMTP working**: Test emails send successfully
- [ ] **Contact forms tested**: Inquiries reach admin
- [ ] **Order notifications**: Customers receive confirmations
- [ ] **Admin notifications**: New orders alert admin

### 💾 Backup & Monitoring

#### Backup Setup
- [ ] **Database backup scheduled**: Daily automated backups
- [ ] **File backup configured**: Regular site file backups  
- [ ] **Backup testing**: Restore process verified
- [ ] **Off-site storage**: Backups stored securely

#### Monitoring Setup
- [ ] **Uptime monitoring**: Service to check site availability
- [ ] **Log monitoring**: Error logs reviewed regularly
- [ ] **Disk space monitoring**: Alerts for low disk space
- [ ] **Performance monitoring**: Page speed tracking

### 🎯 Go-Live Tasks

#### Final Verification
- [ ] **All URLs working**: No 404 errors on main pages
- [ ] **SSL certificate valid**: Green padlock in browser
- [ ] **Forms submitting**: Contact and inquiry forms work
- [ ] **Admin access confirmed**: Can log into dashboard
- [ ] **Payment testing**: (If applicable) Payment gateways work
- [ ] **Mobile testing**: Full functionality on mobile devices

#### Launch Checklist
- [ ] **DNS propagated**: Domain resolves to new server
- [ ] **Old site redirected**: (If applicable) Previous site redirects
- [ ] **Search engines notified**: Submitted new sitemap
- [ ] **Social media updated**: Links point to new site
- [ ] **Business cards updated**: (If applicable) New domain printed

### 📞 Post-Launch Support

#### Immediate Post-Launch
- [ ] **24-hour monitoring**: Watch for any issues
- [ ] **User feedback collected**: Monitor for user reports
- [ ] **Performance metrics**: Track page loads and errors
- [ ] **Search rankings**: Monitor SEO performance

#### Ongoing Maintenance
- [ ] **Security updates scheduled**: Regular PHP/Laravel updates
- [ ] **Content updates planned**: Product additions and changes
- [ ] **Backup verification**: Regular restore testing
- [ ] **Performance review**: Monthly speed and optimization review

---

## 🎉 Launch Complete!

### ✅ **Your MSK COMPUTERS website is now live at https://mskcomputers.lk**

### 📋 **Quick Reference:**
- **Admin Panel**: https://mskcomputers.lk/admin
- **Sitemap**: https://mskcomputers.lk/sitemap.xml
- **SSL Check**: Use SSL Labs SSL Server Test
- **Speed Test**: Use Google PageSpeed Insights
- **Mobile Test**: Use Google Mobile-Friendly Test

### 🚀 **Next Steps:**
1. Monitor site performance for first 48 hours
2. Set up Google Search Console
3. Submit sitemap to search engines
4. Plan content marketing strategy
5. Regular security and performance reviews

**Congratulations on successfully launching MSK COMPUTERS online! 🎊**