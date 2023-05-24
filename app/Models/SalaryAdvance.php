<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class SalaryAdvance extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'employee_name', 'creator_name', 'loan_amount_readable', 'position_name',
        'monthly_deduction_readable',
        // 'status_readable', 'status_color',
    ];

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = Schema::getColumnListing($this->getTable());
    }


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

    public function foreman()
    {
        return $this->belongsTo(Employee::class, "foreman_id", "id");
    }

    public function creator()
    {
        return $this->belongsTo(User::class, "created_by", "id");
    }

    public function getEmployeeNameAttribute()
    {
        if ($this->employee) {
            return $this->employee->name;
        }
    }

    public function getCreatorNameAttribute()
    {
        if ($this->creator) {
            return $this->creator->name;
        }
    }


    public function getLoanAmountReadableAttribute()
    {
        $loanAmount = number_format($this->loan_amount, 0, ',', '.');
        return "Rp {$loanAmount}";
    }

    public function getPositionNameAttribute()
    {
        if ($this->employee) {
            return $this->employee->position_name;
        } else {
            return null;
        }
    }

    public function getMonthlyDeductionReadAbleAttribute()
    {
        $loanAmount = number_format($this->monthly_deduction, 0, ',', '.');
        return "Rp {$loanAmount}";
    }

    // public function getStatusReadableAttribute()
    // {
    //     $getStatus = Config::get("library.status.{$this->status}");

    //     return $getStatus["readable"];
    // }

    // public function getStatusColorAttribute()
    // {
    //     $getStatus = Config::get("library.status.{$this->status}");

    //     return $getStatus["color"];
    // }
}
