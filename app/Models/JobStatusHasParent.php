<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatusHasParent extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'parent_model',
        'job_order_id',
        'employee_id',
        'status',
        'datetime_start',
        'datetime_end',
        'note_start',
        'note_end',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = request("user_id");
            $model->updated_by = NULL;
        });

        static::updating(function ($model) {
            $model->updated_by = request("user_id");
        });
    }
}
