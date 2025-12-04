# BudgetIQ Documentation

## Table of Contents

1. [System Overview](#system-overview)
2. [Architecture](#architecture)
3. [Installation](#installation)
4. [User Roles & Permissions](#user-roles--permissions)
5. [Core Features](#core-features)
6. [Workflow](#workflow)
7. [API Reference](#api-reference)
8. [Database Schema](#database-schema)
9. [Configuration](#configuration)
10. [Deployment](#deployment)
11. [Troubleshooting](#troubleshooting)

---

## System Overview

BudgetIQ is a comprehensive budget management and payment request system built with Laravel and Livewire. It provides organizations with tools to manage budgets, process payment requests, and enforce multi-level approval workflows.

### Key Capabilities

-   **Budget Management**: Create and track OPEX and CAPEX budgets with period-based allocation
-   **Payment Requests**: Submit, review, and approve payment requests with line-item detail
-   **Approval Workflows**: Multi-level approval system (Finance Manager → CEO)
-   **Role-Based Access**: Granular permissions for Staff, Finance Managers, and Executives
-   **Real-Time Notifications**: Push notifications for approval actions and status updates
-   **Invoice Management**: Upload and attach supporting documents to payment requests
-   **Analytics**: Track spending patterns, budget utilization, and approval metrics
-   **Audit Trail**: Complete history of all actions and changes

---

## Architecture

### Technology Stack

-   **Backend**: Laravel 12.x (PHP 8.2+)
-   **Frontend**: Livewire 3.x with Flux UI components
-   **Database**: PostgreSQL (recommended) or MySQL
-   **Styling**: Tailwind CSS 4.x
-   **Notifications**: Laravel WebPush
-   **Authentication**: Laravel Fortify with 2FA support

### Application Structure

```
app/
├── Livewire/              # Livewire components
│   ├── Budgets/           # Budget management
│   ├── PaymentRequests/   # Payment request handling
│   ├── Users/             # User management
│   └── Dashboard.php      # Main dashboard
├── Models/                # Eloquent models
├── Notifications/         # Notification classes
└── Services/              # Business logic services

resources/
├── views/
│   ├── livewire/          # Livewire views
│   └── components/        # Reusable components
├── css/                   # Stylesheets
└── js/                    # JavaScript assets

database/
├── migrations/            # Database migrations
└── seeders/               # Database seeders
```

---

## Installation

### Prerequisites

-   PHP 8.2 or higher
-   Composer 2.x
-   Node.js 16+ and npm
-   PostgreSQL 13+ or MySQL 8+
-   Redis (optional, for caching and queues)

### Setup Steps

1. **Clone the repository**

```bash
git clone <repository-url>
cd budgetiq
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install JavaScript dependencies**

```bash
npm install
```

4. **Environment configuration**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**

Edit `.env` file:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=budgetiq
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations**

```bash
php artisan migrate
```

7. **Build frontend assets**

```bash
npm run build
```

8. **Start development server**

```bash
php artisan serve
```

Access the application at `http://localhost:8000`

---

## User Roles & Permissions

### Staff

**Capabilities:**

-   Create and submit payment requests
-   View own payment requests
-   Upload invoices and attachments
-   Track request status
-   Receive notifications on approvals/rejections

**Restrictions:**

-   Cannot approve requests
-   Cannot view other users' requests
-   Cannot manage budgets
-   Cannot access user management

### Finance Manager

**Capabilities:**

-   All Staff capabilities
-   Review and approve/reject payment requests (first level)
-   View all payment requests
-   Create and manage budgets
-   View financial analytics
-   Manage departments and cost centers

**Restrictions:**

-   Cannot provide final approval (CEO level)
-   Cannot manage user roles

### CEO

**Capabilities:**

-   All Finance Manager capabilities
-   Final approval authority on payment requests
-   Access to complete system analytics
-   User management and role assignment
-   System-wide configuration

---

## Core Features

### 1. Budget Management

**Creating Budgets**

Budgets define spending limits for specific periods and categories.

Fields:

-   Title and description
-   Budget type (OPEX/CAPEX)
-   Amount and currency (GHS, USD, EUR)
-   Period (start and end dates)
-   Department/Project/Cost Center assignment
-   Status (draft, pending, approved, rejected)

**Budget Tracking**

-   Real-time utilization monitoring
-   Remaining balance calculations
-   Period-based reporting
-   Budget vs. actual spending analysis

### 2. Payment Requests

**Request Creation**

Staff members create payment requests with:

-   Title and purpose
-   Expense type (OPEX/CAPEX)
-   Currency selection
-   Line items (description, quantity, unit price)
-   Vendor information
-   Supporting documents/invoices
-   Budget allocation

**Line Items**

Each request contains itemized details:

```
Description | Quantity | Unit Price | Total
Office Supplies | 10 | 50.00 | 500.00
```

**Attachments**

Supported formats: PDF, JPG, JPEG, PNG (max 10MB per file)

### 3. Approval Workflow

**Two-Level Approval Process**

1. **Finance Manager Review**

    - Validates budget availability
    - Reviews supporting documents
    - Checks compliance with policies
    - Approves or rejects with comments

2. **CEO Final Approval**
    - Reviews Finance Manager's assessment
    - Provides final authorization
    - Can reject even after FM approval

**Status Flow**

```
Draft → Pending → Approved by FM → Approved by CEO
                ↓                  ↓
              Rejected          Rejected
```

**Notifications**

Users receive real-time push notifications for:

-   Request submissions
-   Approval actions
-   Rejections with reasons
-   Status changes

### 4. Analytics & Reporting

**Dashboard Metrics**

-   Total requests (by status)
-   Pending approvals count
-   Approved/rejected statistics
-   OPEX vs CAPEX breakdown
-   Monthly spending trends
-   Budget utilization rates

**Reports Available**

-   Payment request history
-   Budget performance
-   Approval turnaround times
-   Department-wise spending
-   Vendor payment tracking

### 5. User Management

**User Administration** (CEO only)

-   Create/edit/deactivate users
-   Assign roles and permissions
-   Reset passwords
-   View user activity logs

**Profile Management** (All users)

-   Update personal information
-   Change password
-   Upload profile picture
-   Enable two-factor authentication
-   Configure notification preferences

---

## Workflow

### Typical Payment Request Flow

1. **Staff Submission**

    - Staff logs in and navigates to "Payment Requests"
    - Clicks "Create New Request"
    - Fills in request details and line items
    - Uploads invoice/supporting documents
    - Selects budget to charge against
    - Submits request

2. **Finance Manager Review**

    - Receives notification of new request
    - Reviews request details and attachments
    - Verifies budget availability
    - Adds comments if needed
    - Approves or rejects

3. **CEO Final Approval**

    - Receives notification after FM approval
    - Reviews complete request package
    - Provides final approval or rejection
    - Request marked as "Approved by CEO"

4. **Completion**
    - Staff receives approval notification
    - Request can be processed for payment
    - Budget is updated with actual spend
    - Audit trail is complete

---

## API Reference

### Authentication

All API requests require authentication via Laravel Sanctum tokens.

**Login**

```http
POST /login
Content-Type: application/json

{
  "email": "user@company.com",
  "password": "password"
}
```

### Payment Requests

**List Requests**

```http
GET /api/payment-requests
Authorization: Bearer {token}
```

**Create Request**

```http
POST /api/payment-requests
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Office Equipment",
  "expense_type": "OPEX",
  "currency": "GHS",
  "budget_id": 1,
  "line_items": [
    {
      "description": "Laptop",
      "quantity": 2,
      "unit_price": 3000
    }
  ]
}
```

**Approve Request**

```http
POST /api/payment-requests/{id}/approve
Authorization: Bearer {token}
Content-Type: application/json

{
  "comment": "Approved for processing"
}
```

### Budgets

**List Budgets**

```http
GET /api/budgets
Authorization: Bearer {token}
```

**Create Budget**

```http
POST /api/budgets
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Q1 2024 Operations",
  "amount": 50000,
  "currency": "GHS",
  "period_start": "2024-01-01",
  "period_end": "2024-03-31"
}
```

---

## Database Schema

### Key Tables

**users**

-   id, name, email, password
-   email_verified_at, two_factor_secret
-   profile_photo_path
-   timestamps

**roles**

-   id, name, slug
-   timestamps

**budgets**

-   id, title, description, amount, currency
-   period_start, period_end
-   status, expense_type
-   department_id, project_id, cost_center_id
-   created_by, approved_by
-   timestamps

**payment_requests**

-   id, title, description, amount, currency
-   amount_in_words, status, expense_type
-   purpose, prepared_by, request_date
-   vendor_name, vendor_details (JSON)
-   budget_id, requester_id
-   department_id, project_id, cost_center_id
-   timestamps

**line_items**

-   id, payment_request_id
-   description, quantity, unit_price, total_price
-   line_order
-   timestamps

**approvals**

-   id, payment_request_id, approver_id
-   role, status, comment
-   approved_at, rejected_at
-   timestamps

**attachments**

-   id, payment_request_id
-   filename, path, mime_type, size
-   uploaded_by
-   timestamps

### Relationships

```
User
├── hasMany PaymentRequests (as requester)
├── hasMany Approvals (as approver)
└── belongsToMany Roles

PaymentRequest
├── belongsTo User (requester)
├── belongsTo Budget
├── hasMany LineItems
├── hasMany Attachments
└── hasMany Approvals

Budget
├── belongsTo User (creator)
├── belongsTo Department
├── belongsTo Project
└── hasMany PaymentRequests
```

---

## Configuration

### Environment Variables

**Application**

```env
APP_NAME=BudgetIQ
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
APP_KEY=base64:...
```

**Database**

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=budgetiq
DB_USERNAME=db_user
DB_PASSWORD=db_password
```

**Mail** (for notifications)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@company.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Push Notifications**

```env
VAPID_PUBLIC_KEY=your-public-key
VAPID_PRIVATE_KEY=your-private-key
VAPID_SUBJECT=mailto:admin@company.com
```

Generate VAPID keys:

```bash
php artisan webpush:vapid
```

### Cache & Queue

For production, use Redis:

```env
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

---

## Deployment

### Production Checklist

1. **Server Requirements**

    - PHP 8.2+ with extensions: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
    - Web server (Nginx or Apache)
    - PostgreSQL or MySQL
    - Redis (recommended)
    - SSL certificate

2. **Optimize Application**

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Set Permissions**

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

4. **Configure Web Server**

**Nginx Example**

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/budgetiq/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

5. **Setup Queue Worker**

Create systemd service `/etc/systemd/system/budgetiq-worker.service`:

```ini
[Unit]
Description=BudgetIQ Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/budgetiq/artisan queue:work --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target
```

Enable and start:

```bash
systemctl enable budgetiq-worker
systemctl start budgetiq-worker
```

6. **Setup Scheduler**

Add to crontab:

```bash
* * * * * cd /var/www/budgetiq && php artisan schedule:run >> /dev/null 2>&1
```

7. **SSL Certificate**

```bash
certbot --nginx -d your-domain.com
```

### Docker Deployment

Use the included `Dockerfile`:

```bash
docker build -t budgetiq .
docker run -d -p 80:80 \
  -e DB_HOST=your-db-host \
  -e DB_DATABASE=budgetiq \
  -e DB_USERNAME=db_user \
  -e DB_PASSWORD=db_password \
  budgetiq
```

---

## Troubleshooting

### Common Issues

**Issue: 500 Internal Server Error**

Solution:

```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Verify permissions
chmod -R 755 storage bootstrap/cache
```

**Issue: Database Connection Failed**

Solution:

-   Verify database credentials in `.env`
-   Check database server is running
-   Ensure database exists
-   Test connection: `php artisan tinker` then `DB::connection()->getPdo();`

**Issue: Assets Not Loading**

Solution:

```bash
# Rebuild assets
npm run build

# Check public/build directory exists
ls -la public/build

# Verify APP_URL in .env matches your domain
```

**Issue: Push Notifications Not Working**

Solution:

```bash
# Regenerate VAPID keys
php artisan webpush:vapid

# Update keys in .env
# Clear config cache
php artisan config:clear

# Check browser permissions
# Verify HTTPS is enabled (required for push notifications)
```

**Issue: Queue Jobs Not Processing**

Solution:

```bash
# Check queue worker is running
systemctl status budgetiq-worker

# Restart worker
systemctl restart budgetiq-worker

# Process jobs manually
php artisan queue:work --once
```

### Performance Optimization

**Enable OPcache** (php.ini):

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0
```

**Database Indexing**

Ensure indexes exist on:

-   payment_requests: status, requester_id, budget_id
-   approvals: payment_request_id, approver_id, status
-   budgets: status, period_start, period_end

**Redis Caching**

```bash
# Cache frequently accessed data
php artisan cache:clear
php artisan config:cache
php artisan route:cache
```

### Logs & Monitoring

**Application Logs**

```bash
tail -f storage/logs/laravel.log
```

**Web Server Logs**

```bash
# Nginx
tail -f /var/log/nginx/error.log

# Apache
tail -f /var/log/apache2/error.log
```

**Database Queries**

Enable query logging in `.env`:

```env
DB_LOG_QUERIES=true
```

---

## Support & Maintenance

### Backup Strategy

**Database Backups**

```bash
# PostgreSQL
pg_dump -U db_user budgetiq > backup_$(date +%Y%m%d).sql

# MySQL
mysqldump -u db_user -p budgetiq > backup_$(date +%Y%m%d).sql
```

**File Backups**

```bash
tar -czf budgetiq_files_$(date +%Y%m%d).tar.gz \
  storage/app/public \
  .env
```

### Updates

```bash
# Pull latest code
git pull origin main

# Update dependencies
composer install --no-dev
npm install && npm run build

# Run migrations
php artisan migrate --force

# Clear caches
php artisan optimize:clear
php artisan optimize
```

### Security Best Practices

-   Keep Laravel and dependencies updated
-   Use strong APP_KEY (never commit to git)
-   Enable HTTPS/SSL in production
-   Set APP_DEBUG=false in production
-   Implement rate limiting on API endpoints
-   Regular security audits
-   Monitor logs for suspicious activity
-   Use environment-specific .env files
-   Implement database backups
-   Enable two-factor authentication for admin users

---

## License

Proprietary - All rights reserved
