<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentRequest extends Model
{
    protected $fillable = [
        'title', 'description', 'amount', 'amount_in_words', 'status',
        'expense_type', 'purpose', 'prepared_by', 'request_date',
        'vendor_name', 'vendor_details', 'department_id', 'project_id',
        'cost_center_id', 'budget_id', 'requester_id', 'submitted_at'
    ];

    protected $casts = [
        'vendor_details' => 'array',
        'request_date' => 'date',
        'submitted_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(LineItem::class)->orderBy('line_order');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApprovedByFM(): bool
    {
        return $this->status === 'approved_by_fm';
    }

    public function isApprovedByCEO(): bool
    {
        return $this->status === 'approved_by_ceo';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
