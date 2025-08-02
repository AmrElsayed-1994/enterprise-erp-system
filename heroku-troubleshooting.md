# Heroku 500 Error Troubleshooting Guide

## Common Causes and Solutions

### 1. Database Connection Issues
**Problem**: PostgreSQL connection fails or database doesn't exist
**Solution**: 
```bash
# Check database URL
heroku config:get DATABASE_URL -a your-app-name

# Run migrations manually
heroku run php artisan migrate --force -a your-app-name

# Check database connection
heroku run php artisan tinker -a your-app-name
# Then run: DB::connection()->getPdo();
```

### 2. Missing APP_KEY
**Problem**: Laravel APP_KEY not generated
**Solution**:
```bash
# Generate new key
heroku run php artisan key:generate --force -a your-app-name

# Or set manually
heroku config:set APP_KEY=base64:your-generated-key -a your-app-name
```

### 3. Cache/Config Issues
**Problem**: Cached config conflicts with production environment
**Solution**:
```bash
# Clear all caches
heroku run php artisan config:clear -a your-app-name
heroku run php artisan route:clear -a your-app-name
heroku run php artisan view:clear -a your-app-name

# Rebuild caches
heroku run php artisan config:cache -a your-app-name
heroku run php artisan route:cache -a your-app-name
```

### 4. Permission Issues
**Problem**: Storage directory permissions
**Solution**:
```bash
# Check storage permissions
heroku run ls -la storage/ -a your-app-name

# Create storage directories if missing
heroku run php artisan storage:link -a your-app-name
```

### 5. Environment Variables
**Problem**: Missing or incorrect environment variables
**Solution**:
```bash
# Check all config vars
heroku config -a your-app-name

# Set required variables
heroku config:set APP_DEBUG=true -a your-app-name
heroku config:set LOG_LEVEL=debug -a your-app-name
heroku config:set SESSION_DRIVER=database -a your-app-name
```

## Debugging Steps

### Step 1: Enable Debug Mode
```bash
heroku config:set APP_DEBUG=true -a your-app-name
heroku config:set LOG_LEVEL=debug -a your-app-name
```

### Step 2: Check Logs
```bash
# View real-time logs
heroku logs --tail -a your-app-name

# View specific log lines
heroku logs --num=100 -a your-app-name
```

### Step 3: Test Database Connection
```bash
# Connect to database
heroku pg:psql -a your-app-name

# Check tables
\dt

# Exit
\q
```

### Step 4: Run Migrations
```bash
# Check migration status
heroku run php artisan migrate:status -a your-app-name

# Run migrations
heroku run php artisan migrate --force -a your-app-name

# Seed database
heroku run php artisan db:seed --force -a your-app-name
```

### Step 5: Test Application
```bash
# Test routes
heroku run php artisan route:list -a your-app-name

# Test in tinker
heroku run php artisan tinker -a your-app-name
```

## Quick Fix Commands

Run these commands in order to fix most common issues:

```bash
# Replace 'your-app-name' with your actual Heroku app name

# 1. Enable debugging
heroku config:set APP_DEBUG=true LOG_LEVEL=debug -a your-app-name

# 2. Clear caches
heroku run php artisan config:clear -a your-app-name
heroku run php artisan route:clear -a your-app-name
heroku run php artisan view:clear -a your-app-name

# 3. Generate app key if missing
heroku run php artisan key:generate --force -a your-app-name

# 4. Run migrations
heroku run php artisan migrate --force -a your-app-name

# 5. Seed database
heroku run php artisan db:seed --force -a your-app-name

# 6. Rebuild caches
heroku run php artisan config:cache -a your-app-name
heroku run php artisan route:cache -a your-app-name

# 7. Check logs
heroku logs --tail -a your-app-name
```

## Login Credentials for Testing

After successful deployment, use these credentials:

- **Super Admin:** `superadmin@erp.com` / `password`
- **Admin:** `admin@erp.com` / `password`
- **Demo User:** `demo@erp.com` / `password`
