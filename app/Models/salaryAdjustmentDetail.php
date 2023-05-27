<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class salaryAdjustmentDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        //
    ];
    protected $fillable = [
        "salary_adjustment_id", "employee_id", "type_amount", "amount",
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

    public function employee()
    {
        return $this->belongsTo(Employee::class, "employee_id", "id");
    }
}
