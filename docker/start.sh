#!/bin/bash

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
