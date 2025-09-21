# 📋 aaaPanel Deployment Checklist

## Pre-Deployment (Local)
- [ ] Test application locally
- [ ] Update .env with production settings
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Clear all caches locally
- [ ] Create ZIP package of project

## aaaPanel Setup
- [ ] Create website in aaaPanel
- [ ] Set PHP version to 8.1+
- [ ] Configure domain DNS
- [ ] Set document root to `/public`

## File Upload
- [ ] Upload all Laravel files
- [ ] Upload vendor folder (if not using Composer)
- [ ] Set correct folder permissions (755)
- [ ] Verify .htaccess in public folder

## Database Setup
- [ ] Create main database: `msk_computers`
- [ ] Create products database: `msk_computers_products`  
- [ ] Import database structure/data
- [ ] Test database connections

## Environment Configuration
- [ ] Upload/edit .env file
- [ ] Generate new APP_KEY
- [ ] Update database credentials
- [ ] Set correct APP_URL
- [ ] Configure payment gateway URLs

## SSL & Security
- [ ] Install SSL certificate
- [ ] Force HTTPS redirect
- [ ] Test secure connections
- [ ] Verify all assets load over HTTPS

## Testing
- [ ] Homepage loads correctly
- [ ] User registration/login works
- [ ] Product pages display properly
- [ ] Cart functionality works
- [ ] Checkout process functions
- [ ] Payment gateways work
- [ ] Admin panel accessible
- [ ] Email sending works

## Performance
- [ ] Enable OPcache
- [ ] Set memory limits
- [ ] Configure cache settings
- [ ] Test page load speeds

## Final Steps
- [ ] Set up backups
- [ ] Configure error logging
- [ ] Monitor error logs
- [ ] Update DNS if needed
- [ ] Test from different devices

## Post-Deployment
- [ ] Monitor for 24 hours
- [ ] Check error logs daily
- [ ] Test all payment methods
- [ ] Verify email notifications
- [ ] Update documentation

## Emergency Contacts
- aaaPanel Support: [Your hosting provider]
- Domain Registrar: [Your domain provider]
- Payment Gateway Support: [Gateway providers]

---

**Notes:**
- Keep database credentials secure
- Monitor server resources
- Set up regular backups
- Document any custom configurations
