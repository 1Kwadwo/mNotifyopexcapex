# OPEX/CAPEX Management System

A streamlined invoice and budget management system for organizations to manage operational (OPEX) and capital (CAPEX) expenditures through a simplified 2-stage approval workflow.

## 🚀 Features Implemented

### Phase 1: Foundation ✅
- ✅ Database migrations for all tables
- ✅ Eloquent models with relationships
- ✅ Role-based authentication (Staff, Finance Manager, CEO)
- ✅ Seeders for roles and demo users
- ✅ Service classes for business logic
- ✅ Authorization policies

### Phase 2: Core Functionality ✅
- ✅ Dashboard with stats and recent activity
- ✅ Payment Request creation with dynamic line items
- ✅ Budget management
- ✅ 2-stage approval workflow (FM → CEO)
- ✅ Budget tracking (reserve/release/commit)
- ✅ Audit logging

### Phase 3: User Interface ✅
- ✅ Responsive Livewire Flux UI
- ✅ Payment request list and detail views
- ✅ Budget list view
- ✅ Approval interface
- ✅ Status badges and progress indicators

## 👥 Demo Users

The system comes with 3 pre-configured users:

| Role | Email | Password | Capabilities |
|------|-------|----------|--------------|
| CEO | ceo@example.com | password | Final approval on invoices and budgets |
| Finance Manager | finance@example.com | password | Review invoices, create budgets, manage users |
| Staff | staff@example.com | password | Submit invoices, view own requests |

## 🗄️ Database Schema

### Core Tables
- `users` - User accounts
- `roles` - User roles (staff, finance_manager, ceo)
- `role_user` - User-role pivot table
- `payment_requests` - Invoice/payment requests
- `line_items` - Invoice line items
- `budgets` - Budget allocations
- `budget_transactions` - Budget transaction history
- `approvals` - Approval records
- `audit_logs` - Complete audit trail

### Optional Tables
- `departments` - Organizational departments
- `cost_centers` - Cost center tracking
- `projects` - Project assignments
- `attachments` - File uploads
- `comments` - Request comments

## 🔄 Approval Workflow

```
Staff Submits Invoice
    ↓
Status: "pending"
Budget: Amount reserved
Notification → Finance Manager
    ↓
Finance Manager Reviews
    ├─ Approve → Status: "approved_by_fm" → Notification → CEO
    └─ Reject → Status: "rejected" → Budget released
    ↓
CEO Final Approval
    ├─ Approve → Status: "approved_by_ceo" → Budget committed
    └─ Reject → Status: "rejected" → Budget released
```

## 💰 Budget Management

Budgets track three key amounts:
- **Available Amount**: Funds available for new requests
- **Committed Amount**: Funds allocated to approved requests
- **Spent Amount**: Total funds used

Budget states:
- **Reserve**: When invoice submitted (reduces available)
- **Release**: When invoice rejected (increases available)
- **Commit**: When CEO approves (increases committed & spent)

## 🚀 Getting Started

### Installation

1. Clone the repository
2. Install dependencies:
```bash
composer install
npm install
```

3. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations and seeders:
```bash
php artisan migrate:fresh --seed
php artisan db:seed --class=DemoDataSeeder
```

5. Build assets:
```bash
npm run build
```

6. Start the development server:
```bash
php artisan serve
```

Visit http://localhost:8000 and log in with one of the demo accounts.

## 📋 Usage Guide

### For Staff:
1. Navigate to "Payment Requests" → "New Request"
2. Fill in the form with:
   - Title and purpose
   - Dynamic line items (add/remove rows)
   - Select an approved budget
   - Optional: vendor details, department, project
3. Save as draft or submit for approval
4. Track status on dashboard

### For Finance Manager:
1. Review pending requests on dashboard
2. Click "View" to see request details
3. Approve (forwards to CEO) or Reject (with reason)
4. Create budgets and submit to CEO
5. Create new staff user accounts

### For CEO:
1. Review requests approved by Finance Manager
2. Provide final approval or rejection
3. Approve budgets created by Finance Manager
4. View comprehensive analytics

## 🔐 Security Features

- Laravel Fortify authentication with 2FA support
- Role-based authorization with Policies
- CSRF protection
- XSS protection via Blade escaping
- SQL injection prevention via Eloquent
- Complete audit trail with IP tracking

## 🎨 Technology Stack

**Backend:**
- Laravel 12
- SQLite (development)
- Laravel Fortify (authentication)
- Pest PHP (testing)

**Frontend:**
- Livewire Volt (reactive components)
- Livewire Flux (UI library)
- Tailwind CSS
- Alpine.js

## 📊 Key Features

### Payment Request Form
- Dynamic line items with live total calculation
- Auto-generate amount in words
- Budget validation before submission
- File attachment support
- Draft saving capability

### Dashboard
- Role-specific views
- Quick stats (total, pending, approved, rejected)
- Recent requests table
- Budget utilization overview
- Quick action buttons

### Budget Tracking
- Real-time utilization percentage
- Visual progress bars
- Warning thresholds
- Transaction history
- Period-based budgets

## 🧪 Testing

Run tests with:
```bash
php artisan test
```

## 📝 Next Steps

To complete the full system, implement:

1. **Budget Creation Form** - Full budget creation with breakdown
2. **User Management** - Staff account creation by FM
3. **Notifications** - Email and in-app notifications
4. **File Attachments** - Upload and manage documents
5. **Comments** - Add comments to requests
6. **Reports** - OPEX/CAPEX analysis, exports
7. **Advanced Features**:
   - Budget approval workflow
   - Vendor management
   - Department/project analytics
   - Scheduled reports
   - Email notifications

## 🤝 Contributing

This is a demo system. For production use:
- Add comprehensive tests
- Implement file upload validation
- Add email notifications
- Create detailed reports
- Add data export functionality
- Implement backup strategy

## 📄 License

MIT License

---

**Built with Laravel 12, Livewire Volt, and Livewire Flux**
