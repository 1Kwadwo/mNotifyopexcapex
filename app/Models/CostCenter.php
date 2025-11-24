<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    protected $fillable = ['name', 'code', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
