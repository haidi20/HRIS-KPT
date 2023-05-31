<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOrderHistory extends Model
{
    use HasFactory, SoftDeletes;

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class, "job_order_id", "id");
    }
}
