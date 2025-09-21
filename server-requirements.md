# 🖥️ Server Requirements for MSK Computers

## Minimum aaaPanel Server Requirements

### PHP Requirements
- **PHP Version:** 8.1 or higher ⚠️ **CRITICAL**
- **Memory Limit:** 512MB minimum (1GB recommended)
- **Execution Time:** 300 seconds
- **Upload Size:** 100MB minimum

### Required PHP Extensions
✅ **Essential Extensions:**
- `BCMath` - For precise calculations
- `Ctype` - Character type checking
- `Fileinfo` - File information
- `JSON` - JSON data handling
- `Mbstring` - Multi-byte string handling
- `OpenSSL` - Security/encryption
- `PDO` - Database connectivity
- `Tokenizer` - PHP tokenization
- `XML` - XML processing
- `cURL` - HTTP requests
- `GD` or `Imagick` - Image processing
- `Zip` - Archive handling

### Database Requirements
- **MySQL:** 8.0+ or **MariaDB:** 10.3+
- **Storage:** 5GB minimum (10GB recommended)
- **Databases Needed:** 2 (main + products)

### Web Server
- **Apache:** 2.4+ with mod_rewrite enabled
- **Nginx:** 1.18+ (alternative)
- **Document Root:** Must point to `/public` folder

### SSL/Security
- **SSL Certificate:** Required (Let's Encrypt supported)
- **HTTPS:** Force redirect enabled
- **Firewall:** Basic protection enabled

## aaaPanel Specific Settings

### PHP Manager Settings
```
Memory Limit: 1024M
Max Execution Time: 300
Max Input Vars: 3000
Upload Max Size: 100M
Post Max Size: 100M
```

### Database Settings
```
Max Connections: 100
Query Cache: Enabled
InnoDB Buffer Pool: 256MB minimum
```

### File Permissions
```
Laravel Root: 755
storage/: 755 (recursive)
bootstrap/cache/: 755 (recursive)
public/: 755
```

## Performance Recommendations

### OPcache Settings (Recommended)
```
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=12
opcache.max_accelerated_files=10000
opcache.validate_timestamps=0 (production)
```

### Cache Settings
```
Cache Driver: file (default)
Session Driver: file
Queue: sync (basic setup)
```

## Bandwidth & Storage

### Expected Usage
- **Monthly Bandwidth:** 50GB minimum
- **Storage Space:** 10GB minimum
- **Backup Space:** Additional 5GB
- **Email Storage:** 2GB

### File Upload Limits
- **Product Images:** 10MB per file
- **Profile Photos:** 5MB per file
- **Documents:** 50MB per file

## Monitoring Requirements

### Log Management
- **Error Logs:** Enable and monitor
- **Access Logs:** Keep for analysis
- **Laravel Logs:** Monitor daily
- **Database Logs:** Enable slow query log

### Backup Requirements
- **Database Backup:** Daily automated
- **File Backup:** Weekly automated
- **Off-site Backup:** Monthly recommended

## Security Requirements

### Basic Security
- **Firewall:** Enable basic rules
- **Fail2Ban:** Install if available
- **Regular Updates:** PHP, MySQL, aaaPanel
- **Strong Passwords:** Database, admin accounts

### Laravel Security
- **APP_DEBUG=false** in production
- **HTTPS Only:** All traffic
- **Session Security:** Secure cookies
- **CSRF Protection:** Enabled (default)

## Third-Party Services

### Payment Gateways
- **Outbound HTTPS:** Port 443 open
- **API Connections:** To payment providers
- **Webhook Endpoints:** Accessible from internet

### Email Service
- **SMTP Access:** Port 587/465
- **Authentication:** App passwords for Gmail
- **SPF/DKIM:** Recommended for deliverability

## Testing Your Server

### Pre-Installation Checks
1. **PHP Version:** `php -v`
2. **Extensions:** Check in aaaPanel PHP settings
3. **Permissions:** Test in File Manager
4. **Database:** Create test connection
5. **SSL:** Verify certificate installation

### Post-Installation Verification
1. **Laravel Homepage:** Loads without errors
2. **Database Connection:** No connection errors
3. **File Uploads:** Test image uploads
4. **Email Sending:** Test registration emails
5. **Payment Gateway:** Test sandbox payments

## Troubleshooting Common Issues

### 500 Internal Server Error
- Check PHP error logs
- Verify file permissions
- Check .env configuration
- Ensure APP_KEY is set

### Database Connection Failed
- Verify credentials in .env
- Check database exists
- Test user permissions
- Check host/port settings

### File Upload Failures
- Check upload limits in PHP
- Verify storage permissions
- Check disk space
- Test file manager access

---

**💡 Pro Tip:** Start with a basic setup and optimize performance after confirming everything works correctly!
