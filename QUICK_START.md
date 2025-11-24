# 🚀 Quick Start Guide - OPEX/CAPEX Management System

## Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (already configured)

## Installation (5 minutes)

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Set Up Database
```bash
# Database is already configured with SQLite
php artisan migrate:fresh --seed
php artisan db:seed --class=DemoDataSeeder
```

### 3. Build Assets
```bash
npm run build
```

### 4. Start Server
```bash
php artisan serve
```

Visit: http://localhost:8000

## 👥 Demo Accounts

| Role | Email | Password |
|------|-------|----------|
| **CEO** | ceo@example.com | password |
| **Finance Manager** | finance@example.com | password |
| **Staff** | staff@example.com | password |

## 🎯 Test the Complete Workflow (5 minutes)

### Step 1: Submit a Payment Request (as Staff)
1. Login as `staff@example.com` / `password`
2. Click "New Payment Request" button
3. Fill in the form:
   - **Title**: "Office Equipment Purchase"
   - **Type**: CAPEX
   - **Budget**: Select "2025 CAPEX Budget"
   - **Purpose**: "Upgrade office equipment for new hires"
   - **Line Items**:
     - Row 1: "Laptop", Qty: 3, Price: 1500
     - Row 2: "Monitor", Qty: 6, Price: 400
     - Click "+ Add Row" for more items
4. Watch the total calculate automatically: $6,900.00
5. Click "Submit for Approval"
6. See status change to "Pending"
7. Logout

### Step 2: Finance Manager Approval
1. Login as `finance@example.com` / `password`
2. See the pending request on dashboard
3. Click "View" on the request
4. Review all details and line items
5. Click "Approve" button
6. See status change to "Approved by FM"
7. Logout

**Note:** If a Finance Manager submits their own request, it automatically skips this step and goes directly to CEO approval (to prevent self-approval).

### Step 3: CEO Final Approval
1. Login as `ceo@example.com` / `password`
2. See the request waiting for final approval
3. Click "View" on the request
4. Review the complete approval history
5. Click "Approve" button
6. See status change to "Approved by CEO"
7. Check the budget utilization updated

### Step 4: Check Budget Impact
1. Navigate to "Budgets" in sidebar
2. Click on "2025 CAPEX Budget"
3. See:
   - Available amount decreased by $6,900
   - Committed amount increased by $6,900
   - Utilization bar updated
   - Transaction history logged

## 🎨 Key Features to Explore

### Dashboard
- View stats: Total, Pending, Approved, Rejected
- See recent payment requests
- Monitor budget utilization with progress bars
- Quick action buttons

### Payment Requests
- **List View**: Filter by status (All, Drafts, Pending, Approved, Rejected)
- **Create**: Dynamic line items, live calculations, amount in words
- **Detail View**: Complete request info, approval history, actions

### Budgets
- **List View**: Grid cards with utilization bars
- **Status Filters**: All, Approved, Pending, Drafts
- **Utilization**: Visual progress with color coding (green < 80%, red > 80%)

### Navigation
- Sidebar with role-based menu items
- Staff sees: Dashboard, Payment Requests, Budgets
- Finance Manager sees: + Users
- CEO sees: All sections

## 🔄 Workflow States

### Payment Request Statuses:
- **Draft**: Saved but not submitted
- **Pending**: Submitted, waiting for FM approval
- **Approved by FM**: FM approved, waiting for CEO
- **Approved by CEO**: Fully approved, budget committed
- **Rejected**: Rejected at any stage, budget released

### Budget Statuses:
- **Draft**: Created but not submitted
- **Pending CEO Approval**: Submitted to CEO
- **Approved**: Active and available for use
- **Rejected**: Rejected by CEO

## 💡 Pro Tips

### Creating Effective Payment Requests:
1. Use clear, descriptive titles
2. Add detailed line items (not just one lump sum)
3. Provide thorough purpose/reason
4. Select the correct budget type (OPEX vs CAPEX)
5. Include vendor details for better tracking

### Budget Management:
1. Create budgets before the period starts
2. Set realistic warning thresholds (default: 80%)
3. Monitor utilization regularly
4. Use department/project assignments for better tracking

### Approval Best Practices:
1. Review all line items carefully
2. Check budget availability before approving
3. Add comments when approving (optional but helpful)
4. Always provide detailed rejection reasons

## 🐛 Troubleshooting

### "Budget not found" error:
- Make sure you ran: `php artisan db:seed --class=DemoDataSeeder`
- This creates the approved budgets needed for testing

### Can't see navigation items:
- Check you're logged in with the correct role
- Staff can't see "Users" menu item (Finance Manager only)

### Line items not calculating:
- Make sure you're entering numbers in Qty and Unit Price
- The total updates automatically when you change values

### Can't approve request:
- Check the request status matches your role:
  - FM can approve "Pending" requests
  - CEO can approve "Approved by FM" requests
- Check you have the correct role assigned

## 📊 Sample Data Included

After seeding, you'll have:
- **3 Users**: CEO, Finance Manager, Staff
- **3 Departments**: IT, HR, Finance
- **2 Cost Centers**: IT Operations, HR Admin
- **1 Project**: Digital Transformation
- **2 Budgets**:
  - Q1 2025 OPEX Budget: $100,000
  - 2025 CAPEX Budget: $500,000

## 🎯 Next Steps

Once you've tested the workflow:

1. **Create your own budget**:
   - Login as Finance Manager
   - Go to Budgets → Create Budget
   - (Note: Full form coming soon, placeholder for now)

2. **Try rejection workflow**:
   - Submit a request as Staff
   - Login as FM and click "Reject"
   - Provide a reason
   - Check budget was released

3. **Test budget limits**:
   - Try submitting a request larger than available budget
   - System should prevent submission

4. **Explore audit trail**:
   - Check `audit_logs` table in database
   - See all actions logged with timestamps and IP

## 🔧 Development Mode

For active development:

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Watch for asset changes
npm run dev

# Terminal 3: Watch logs
php artisan pail
```

## 📚 Documentation

- **README_OPEX_CAPEX.md**: Complete system documentation
- **IMPLEMENTATION_SUMMARY.md**: Technical implementation details
- **This file**: Quick start guide

## 🎉 You're Ready!

The system is fully functional for the core workflow:
- ✅ Create payment requests with line items
- ✅ 2-stage approval (FM → CEO)
- ✅ Budget tracking and validation
- ✅ Role-based access control
- ✅ Audit logging
- ✅ Responsive UI

Start by logging in as Staff and creating your first payment request!

---

**Need Help?** Check the other documentation files or review the code comments.
