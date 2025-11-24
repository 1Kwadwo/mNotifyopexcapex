# Approval Workflow Documentation

## 📋 Payment Request Approval Flow

### Role-Based Workflow

The system uses a **2-stage approval process** with intelligent routing based on the requester's role:

---

## 🔄 Workflow by Role

### 1. **Staff Member Submits Request**

```
Staff Creates Request
    ↓
Status: "draft"
    ↓
Staff Submits
    ↓
Status: "pending"
Budget: Amount RESERVED
Notification → Finance Manager
    ↓
Finance Manager Reviews
    ├─ Approve ✅
    │   ↓
    │   Status: "approved_by_fm"
    │   Notification → CEO
    │   ↓
    │   CEO Reviews
    │   ├─ Approve ✅
    │   │   ↓
    │   │   Status: "approved_by_ceo"
    │   │   Budget: Amount COMMITTED
    │   │   Notification → All
    │   │
    │   └─ Reject ❌
    │       ↓
    │       Status: "rejected"
    │       Budget: Amount RELEASED
    │       Notification → Staff
    │
    └─ Reject ❌
        ↓
        Status: "rejected"
        Budget: Amount RELEASED
        Notification → Staff
```

**Key Points:**
- Staff requests require **2 approvals** (FM → CEO)
- Finance Manager **cannot** approve their own requests
- Budget is reserved immediately on submission
- Budget is released if rejected at any stage
- Budget is committed only when CEO approves

---

### 2. **Finance Manager Submits Request**

```
Finance Manager Creates Request
    ↓
Status: "draft"
    ↓
Finance Manager Submits
    ↓
Status: "approved_by_fm" (AUTO-APPROVED)
Budget: Amount RESERVED
Notification → CEO
    ↓
CEO Reviews
    ├─ Approve ✅
    │   ↓
    │   Status: "approved_by_ceo"
    │   Budget: Amount COMMITTED
    │   Notification → All
    │
    └─ Reject ❌
        ↓
        Status: "rejected"
        Budget: Amount RELEASED
        Notification → Finance Manager
```

**Key Points:**
- Finance Manager requests **skip FM approval stage**
- Status automatically set to "approved_by_fm" on submission
- Goes directly to CEO for final approval
- Only requires **1 approval** (CEO)
- Prevents self-approval conflict

**Rationale:**
- Finance Managers shouldn't approve their own requests
- Having another FM approve creates dependency issues
- CEO is the ultimate authority, so direct routing makes sense
- Maintains proper separation of duties

---

### 3. **CEO Submits Request**

```
CEO Creates Request
    ↓
Status: "draft"
    ↓
CEO Submits
    ↓
Status: "approved_by_fm" (AUTO-APPROVED)
Budget: Amount RESERVED
Notification → CEO (self)
    ↓
CEO Reviews Own Request
    ├─ Approve ✅
    │   ↓
    │   Status: "approved_by_ceo"
    │   Budget: Amount COMMITTED
    │
    └─ Reject ❌
        ↓
        Status: "rejected"
        Budget: Amount RELEASED
```

**Key Points:**
- CEO requests also skip FM approval
- CEO can approve their own requests (ultimate authority)
- Technically requires **1 approval** (self)
- Maintains audit trail

**Note:** In a real-world scenario, you might want to add a board approval for CEO requests above a certain threshold.

---

## 🔐 Authorization Rules

### Who Can Approve What?

| Requester Role | Status | Who Can Approve | Notes |
|----------------|--------|-----------------|-------|
| **Staff** | pending | Finance Manager | Cannot approve own |
| **Staff** | approved_by_fm | CEO | Final approval |
| **Finance Manager** | approved_by_fm | CEO | Skips FM stage |
| **CEO** | approved_by_fm | CEO | Can self-approve |

### Policy Implementation

**PaymentRequestPolicy:**
```php
public function approve(User $user, PaymentRequest $paymentRequest): bool
{
    // FM can approve pending requests (but not their own)
    if ($user->isFinanceManager() && $paymentRequest->isPending()) {
        return $paymentRequest->requester_id !== $user->id;
    }
    
    // CEO can approve FM-approved requests (including their own)
    if ($user->isCEO() && $paymentRequest->isApprovedByFM()) {
        return true;
    }
    
    return false;
}
```

---

## 💰 Budget Impact

### Budget States During Workflow

| Action | Budget State | Available Amount | Committed Amount | Spent Amount |
|--------|--------------|------------------|------------------|--------------|
| **Submit** | Reserved | Decreases | No change | No change |
| **Reject** | Released | Increases | No change | No change |
| **CEO Approve** | Committed | No change | Increases | Increases |

### Example:

**Initial Budget:** $100,000 available

1. **Staff submits $10,000 request**
   - Available: $90,000 (reserved)
   - Committed: $0
   - Spent: $0

2. **FM approves**
   - Available: $90,000 (still reserved)
   - Committed: $0
   - Spent: $0

3. **CEO approves**
   - Available: $90,000 (committed)
   - Committed: $10,000
   - Spent: $10,000

**If rejected at any stage:**
   - Available: $100,000 (released)
   - Committed: $0
   - Spent: $0

---

## 📊 Dashboard Views

### Staff Dashboard
- Shows only **own requests**
- Pending count includes both "pending" and "approved_by_fm"
- Cannot see other users' requests

### Finance Manager Dashboard
- Shows **all requests**
- Pending count shows requests needing FM approval
- Can see own requests (but can't approve them)
- Can create budgets and users

### CEO Dashboard
- Shows **all requests**
- Pending count shows requests needing CEO approval
- Can approve all requests including own
- Can approve budgets

---

## 🔔 Notifications (Future Enhancement)

When implemented, notifications will be sent:

| Event | Recipients | Message |
|-------|-----------|---------|
| Staff submits | Finance Managers | "New request from [Staff] - $[Amount]" |
| FM submits | CEO | "New request from [FM] - $[Amount]" |
| CEO submits | CEO | "Your request submitted - $[Amount]" |
| FM approves | CEO, Staff | "Request approved by FM - $[Amount]" |
| CEO approves | All involved | "Request APPROVED - $[Amount]" |
| Any rejection | Requester | "Request rejected - [Reason]" |

---

## ✅ Best Practices

### For Staff:
1. Provide detailed line items
2. Include vendor information
3. Attach supporting documents (when feature available)
4. Choose correct budget type (OPEX vs CAPEX)

### For Finance Managers:
1. Review budget availability before approving
2. Verify vendor details
3. Check against budget allocation
4. Add comments explaining approval decision
5. Don't approve own requests (system prevents this)

### For CEO:
1. Review FM's approval comments
2. Check budget utilization trends
3. Consider strategic alignment
4. Approve budgets promptly to unblock requests

---

## 🚨 Edge Cases Handled

1. **FM tries to approve own request**: ❌ Blocked by policy
2. **Insufficient budget**: ❌ Blocked on submission
3. **Budget expired**: ❌ Not shown in dropdown
4. **Concurrent approvals**: ✅ Database transactions prevent conflicts
5. **FM submits request**: ✅ Auto-approved to FM stage, goes to CEO
6. **CEO submits request**: ✅ Auto-approved to FM stage, CEO can self-approve

---

## 📝 Audit Trail

Every action is logged:
- Request created
- Request submitted
- Auto-approved (for FM/CEO)
- Approved by FM
- Approved by CEO
- Rejected by FM/CEO
- Budget reserved
- Budget released
- Budget committed

All logs include:
- User ID
- Timestamp
- IP address
- Old and new values

---

## 🎯 Summary

The approval workflow is designed to:
- ✅ Maintain proper separation of duties
- ✅ Prevent self-approval conflicts
- ✅ Streamline high-level requests (FM/CEO)
- ✅ Ensure CEO has final authority
- ✅ Track all budget changes
- ✅ Provide complete audit trail
- ✅ Support role-based access control

**Result:** A secure, efficient, and auditable approval process!
