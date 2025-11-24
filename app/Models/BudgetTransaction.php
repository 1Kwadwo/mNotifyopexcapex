<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetTransaction extends Model
{
    protected $fillable = ['budget_id', 'payment_request_id', 'type', 'amount', 'balance_after', 'created_by'];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function paymentRequest()
    {
        return $this->belongsTo(PaymentRequest::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
