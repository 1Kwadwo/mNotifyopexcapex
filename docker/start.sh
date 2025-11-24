#!/bin/bash

# Create database directory if it doesn't exist
mkdir -p /var/www/html/database

# Create SQLite database file if it doesn't exist
touch /var/www/html/database/database.sqlite

# Set permissions
chmod 664 /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite

# Run Laravel optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Seed database if needed (only on first deploy)
php artisan db:seed --class=DemoDataSeeder --force || true

# Start Apache
apache2-foreground
