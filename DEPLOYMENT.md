# 🚀 Enterprise ERP System - Deployment Guide

This guide provides detailed instructions for deploying the Enterprise ERP System on various platforms.

## 📋 Prerequisites

- PHP 8.1 or higher
- Composer
- Web server (Apache/Nginx)
- Database (SQLite/MySQL/PostgreSQL)
- SSL certificate (recommended for production)

## 🐳 Docker Deployment (Recommended)

### Quick Start with Docker Compose

```bash
# Clone the repository
git clone https://github.com/AmrElsayed-1994/enterprise-erp-system.git
cd enterprise-erp-system

# Start the application
docker-compose up -d

# Access at http://localhost:8080
```

### Production Docker Deployment

```bash
# Build production image
docker build -t enterprise-erp:latest .

# Run with custom environment
docker run -d \
  --name enterprise-erp \
  -p 80:80 \
  -e APP_ENV=production \
  -e APP_DEBUG=false \
  -e APP_URL=https://your-domain.com \
  -v /path/to/storage:/var/www/html/storage \
  -v /path/to/database:/var/www/html/database \
  enterprise-erp:latest
```

## ☁️ Cloud Platform Deployments

### Railway Deployment

1. **One-Click Deploy**
   ```bash
   # Use the Railway button in README or:
   railway login
   railway new
   railway add
   railway deploy
   ```

2. **Manual Railway Setup**
   ```bash
   # Install Railway CLI
   npm install -g @railway/cli
   
   # Login and deploy
   railway login
   railway new enterprise-erp
   railway add
   railway deploy
   ```

3. **Environment Variables for Railway**
   ```env
   APP_NAME=Enterprise ERP System
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=${{RAILWAY_STATIC_URL}}
   DB_CONNECTION=sqlite
   DB_DATABASE=/var/www/html/database/database.sqlite
   ```

### Heroku Deployment

1. **One-Click Deploy**
   - Click the "Deploy to Heroku" button in README
   - Configure app name and region
   - Set environment variables
   - Deploy

2. **Manual Heroku Setup**
   ```bash
   # Install Heroku CLI
   npm install -g heroku
   
   # Login and create app
   heroku login
   heroku create your-app-name
   
   # Add PostgreSQL addon
   heroku addons:create heroku-postgresql:mini
   
   # Set environment variables
   heroku config:set APP_NAME="Enterprise ERP System"
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)
   
   # Deploy
   git push heroku main
   
   # Run migrations
   heroku run php artisan migrate --seed --force
   ```

### DigitalOcean App Platform

1. **Create App**
   ```yaml
   # .do/app.yaml
   name: enterprise-erp
   services:
   - name: web
     source_dir: /
     github:
       repo: AmrElsayed-1994/enterprise-erp-system
       branch: main
     run_command: |
       php artisan migrate --seed --force
       vendor/bin/heroku-php-apache2 public/
     environment_slug: php
     instance_count: 1
     instance_size_slug: basic-xxs
     envs:
     - key: APP_NAME
       value: "Enterprise ERP System"
     - key: APP_ENV
       value: production
     - key: APP_DEBUG
       value: "false"
   ```

### AWS EC2 Deployment

1. **Launch EC2 Instance**
   ```bash
   # Connect to instance
   ssh -i your-key.pem ubuntu@your-instance-ip
   
   # Update system
   sudo apt update && sudo apt upgrade -y
   
   # Install LAMP stack
   sudo apt install apache2 mysql-server php8.1 php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd -y
   
   # Install Composer
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   ```

2. **Deploy Application**
   ```bash
   # Clone repository
   cd /var/www/html
   sudo git clone https://github.com/AmrElsayed-1994/enterprise-erp-system.git erp
   cd erp
   
   # Install dependencies
   sudo composer install --no-dev --optimize-autoloader
   
   # Set permissions
   sudo chown -R www-data:www-data /var/www/html/erp
   sudo chmod -R 755 /var/www/html/erp/storage
   sudo chmod -R 755 /var/www/html/erp/bootstrap/cache
   
   # Configure environment
   sudo cp .env.example .env
   sudo php artisan key:generate
   
   # Setup database
   sudo touch database/database.sqlite
   sudo chown www-data:www-data database/database.sqlite
   sudo php artisan migrate --seed --force
   ```

3. **Configure Apache**
   ```apache
   # /etc/apache2/sites-available/erp.conf
   <VirtualHost *:80>
       ServerName your-domain.com
       DocumentRoot /var/www/html/erp/public
       
       <Directory /var/www/html/erp/public>
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/erp_error.log
       CustomLog ${APACHE_LOG_DIR}/erp_access.log combined
   </VirtualHost>
   ```

## 🔧 Manual Server Deployment

### Shared Hosting (cPanel)

1. **Upload Files**
   ```bash
   # Create deployment package
   composer install --no-dev --optimize-autoloader
   tar -czf erp-deployment.tar.gz --exclude='.git' --exclude='node_modules' .
   
   # Upload via cPanel File Manager or FTP
   # Extract to public_html or subdirectory
   ```

2. **Configure Environment**
   ```bash
   # Via cPanel Terminal or SSH
   cd public_html/erp
   cp .env.example .env
   php artisan key:generate
   
   # Create SQLite database
   touch database/database.sqlite
   chmod 666 database/database.sqlite
   
   # Run migrations
   php artisan migrate --seed --force
   ```

### VPS/Dedicated Server

1. **Server Setup**
   ```bash
   # Install required packages
   sudo apt update
   sudo apt install nginx mysql-server php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd composer -y
   
   # Configure PHP-FPM
   sudo systemctl enable php8.1-fpm
   sudo systemctl start php8.1-fpm
   ```

2. **Nginx Configuration**
   ```nginx
   # /etc/nginx/sites-available/erp
   server {
       listen 80;
       server_name your-domain.com;
       root /var/www/html/erp/public;
       index index.php index.html;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
       
       location ~ /\.ht {
           deny all;
       }
   }
   ```

## 🔒 SSL/HTTPS Configuration

### Let's Encrypt (Free SSL)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache -y

# Generate certificate
sudo certbot --apache -d your-domain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### Cloudflare SSL

1. Add domain to Cloudflare
2. Update nameservers
3. Enable "Full (Strict)" SSL mode
4. Configure origin certificates

## 📊 Performance Optimization

### Production Optimizations

```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize Composer autoloader
composer install --optimize-autoloader --no-dev

# Enable OPcache
# Add to php.ini:
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

### Database Optimization

```sql
-- MySQL optimizations
SET GLOBAL innodb_buffer_pool_size = 1G;
SET GLOBAL query_cache_size = 64M;
SET GLOBAL query_cache_type = 1;

-- Add indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_roles_name ON roles(name);
```

## 🔍 Monitoring & Maintenance

### Health Checks

```bash
# Create health check endpoint
# Add to routes/web.php:
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected'
    ]);
});
```

### Backup Strategy

```bash
# Database backup script
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u username -p database_name > backup_$DATE.sql

# File backup
tar -czf files_backup_$DATE.tar.gz /var/www/html/erp/storage

# Upload to S3 or other storage
aws s3 cp backup_$DATE.sql s3://your-backup-bucket/
```

### Log Management

```bash
# Rotate Laravel logs
sudo nano /etc/logrotate.d/laravel

/var/www/html/erp/storage/logs/*.log {
    daily
    missingok
    rotate 52
    compress
    notifempty
    create 644 www-data www-data
}
```

## 🚨 Troubleshooting

### Common Issues

**500 Internal Server Error**
```bash
# Check permissions
sudo chown -R www-data:www-data /var/www/html/erp
sudo chmod -R 755 /var/www/html/erp/storage
sudo chmod -R 755 /var/www/html/erp/bootstrap/cache

# Check logs
tail -f /var/www/html/erp/storage/logs/laravel.log
```

**Database Connection Failed**
```bash
# Test database connection
php artisan tinker
DB::connection()->getPdo();

# Check database file permissions (SQLite)
ls -la database/database.sqlite
sudo chown www-data:www-data database/database.sqlite
```

**Session/CSRF Issues**
```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan session:clear

# Check session configuration
php artisan tinker
config('session.driver');
```

### Performance Issues

```bash
# Enable query logging
# Add to AppServiceProvider boot():
if (app()->environment('local')) {
    DB::listen(function ($query) {
        Log::info($query->sql, $query->bindings);
    });
}

# Monitor slow queries
# MySQL: Enable slow query log
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;
```

## 📞 Support

For deployment assistance:
- 📧 Email: support@enterprise-erp.com
- 📖 Documentation: [GitHub Wiki](https://github.com/AmrElsayed-1994/enterprise-erp-system/wiki)
- 🐛 Issues: [GitHub Issues](https://github.com/AmrElsayed-1994/enterprise-erp-system/issues)

---

**Need help with deployment? Create an issue on GitHub or contact support.**
