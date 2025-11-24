<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    protected $fillable = [
        'name', 'type', 'status', 'period_start', 'period_end',
        'total_amount', 'available_amount', 'committed_amount', 'spent_amount',
        'threshold_warning', 'threshold_limit', 'breakdown',
        'department_id', 'cost_center_id', 'project_id', 'created_by'
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'total_amount' => 'decimal:2',
        'available_amount' => 'decimal:2',
        'committed_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function paymentRequests(): HasMany
    {
        return $this->hasMany(PaymentRequest::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(BudgetTransaction::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function utilizationPercentage(): float
    {
        if ($this->total_amount == 0) return 0;
        return (($this->total_amount - $this->available_amount) / $this->total_amount) * 100;
    }

    public function hasAvailableAmount(float $amount): bool
    {
        return $this->available_amount >= $amount;
    }
}
