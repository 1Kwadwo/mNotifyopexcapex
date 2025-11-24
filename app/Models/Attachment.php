<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['payment_request_id', 'filename', 'path', 'mime_type', 'size', 'uploaded_by'];

    public function paymentRequest()
    {
        return $this->belongsTo(PaymentRequest::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
