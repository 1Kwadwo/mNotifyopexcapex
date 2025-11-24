# Bug Fixes

## Issue: TypeError in Payment Request Creation

### Error
```
TypeError - Unsupported operand types: int * string
```

**Location:** `app/Livewire/PaymentRequests/Create.php:63`

### Root Cause
When users interact with the line item form fields, empty inputs are sent as empty strings `""` instead of numeric values. The `calculateTotal()` method was trying to multiply these strings, causing a type error.

### Solution

**1. Updated `calculateTotal()` method to handle non-numeric values:**

```php
public function calculateTotal()
{
    return collect($this->lineItems)->sum(function ($item) {
        $quantity = is_numeric($item['quantity'] ?? 0) ? (float) $item['quantity'] : 0;
        $unitPrice = is_numeric($item['unit_price'] ?? 0) ? (float) $item['unit_price'] : 0;
        return $quantity * $unitPrice;
    });
}
```

**Changes:**
- Check if values are numeric before casting
- Cast to float to handle decimals
- Default to 0 if not numeric

**2. Updated view to handle empty values in display:**

```blade
@php
    $qty = is_numeric($item['quantity'] ?? 0) ? (float) $item['quantity'] : 0;
    $price = is_numeric($item['unit_price'] ?? 0) ? (float) $item['unit_price'] : 0;
@endphp
${{ number_format($qty * $price, 2) }}
```

### Files Modified
- `app/Livewire/PaymentRequests/Create.php`
- `resources/views/livewire/payment-requests/create.blade.php`

### Testing
✅ Empty fields now default to 0  
✅ Total calculates correctly  
✅ No type errors  
✅ Form validation still works  

### Status
🟢 **FIXED** - Payment request creation now handles empty/invalid numeric inputs gracefully.

---

## Issue: flux:banner Component Not Found

### Error
```
InvalidArgumentException - Unable to locate a class or view for component [flux::banner]
```

**Location:** `resources/views/livewire/payment-requests/show.blade.php`

### Root Cause
The view was using `<flux:banner>` component which doesn't exist in the Livewire Flux starter kit.

### Solution
Replaced `flux:banner` with a standard styled div:

**Before:**
```blade
<flux:banner variant="success">{{ session('message') }}</flux:banner>
```

**After:**
```blade
<div class="rounded-lg bg-green-50 p-4 text-green-800 dark:bg-green-900/20 dark:text-green-400">
    {{ session('message') }}
</div>
```

### Files Modified
- `resources/views/livewire/payment-requests/show.blade.php`

### Status
🟢 **FIXED** - Success messages now display correctly with proper styling.
