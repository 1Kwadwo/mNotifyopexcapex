<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['payment_request_id', 'user_id', 'content', 'is_internal'];

    protected $casts = [
        'is_internal' => 'boolean',
    ];

    public function paymentRequest()
    {
        return $this->belongsTo(PaymentRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
