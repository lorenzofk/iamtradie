# Deployment Guide

## Log Viewer Environment Variables

Add these environment variables to your production `.env` file:

```env
# Log Viewer Configuration
LOG_VIEWER_ENABLED=true
LOG_VIEWER_API_ONLY=false

# Optional: Custom cache driver for log viewer
LOG_VIEWER_CACHE_DRIVER=redis

# Optional: API stateful domains (comma-separated)
LOG_VIEWER_API_STATEFUL_DOMAINS=yourdomain.com,www.yourdomain.com
```

## Production Deployment Checklist

### 1. File Permissions
Ensure proper permissions on storage directory:
```bash
sudo chown -R www-data:www-data storage
sudo chmod -R 775 storage
```

### 2. Clear and Cache Configuration
```bash
php artisan config:clear
php artisan config:cache
php artisan view:clear
php artisan route:cache
```

### 3. Log Viewer Security
- ✅ Authentication is automatically enforced in production
- ✅ Only authenticated users can access `/log-viewer`
- ✅ Uses custom middleware and Gate authorization
- ✅ System logs are hidden from the interface

### 4. Asset Compilation
If you modified log viewer assets:
```bash
npm run production
```

### 5. Web Server Configuration
Ensure your web server can read the `storage/logs` directory:
- Nginx: Check that the web server user has read access
- Apache: Verify .htaccess permissions

## Security Notes

- The log viewer is only accessible to authenticated users in production
- Local development allows access without authentication
- Customize authorization in `app/Http/Middleware/EnsureUserCanViewLogs.php`
- Modify gate permissions in `app/Providers/AppServiceProvider.php`

## Troubleshooting

### Log Viewer Not Loading
1. Check file permissions on `storage/logs`
2. Verify web server can read log files
3. Clear configuration cache: `php artisan config:clear`

### Access Denied
1. Ensure user is authenticated
2. Check gate definition in `AppServiceProvider`
3. Verify middleware configuration in `config/log-viewer.php`

### Empty Log List
1. Check if log files exist in `storage/logs`
2. Verify `include_files` configuration in `config/log-viewer.php`
3. Test log generation: `php artisan tinker` then `Log::info('test')` 