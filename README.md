# BudgetIQ

A Laravel-based budget management and payment request system with multi-level approval workflows.

## Features

-   Budget creation and tracking (OPEX/CAPEX)
-   Payment request management
-   Multi-level approval workflows
-   Role-based access control
-   Real-time notifications
-   Invoice upload and management
-   Analytics and reporting

## Requirements

-   PHP 8.1+
-   Composer
-   Node.js 16+
-   PostgreSQL or MySQL
-   Redis (optional, for caching)

## Installation

```bash
# Clone repository
git clone <repository-url>
cd budgetiq

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate

# Build assets
npm run build

# Start development server
php artisan serve
```

## Configuration

Update `.env` with your database credentials and application settings:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=budgetiq
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Deployment

See `DEPLOYMENT_GUIDE.md` for production deployment instructions.

## License

Proprietary
