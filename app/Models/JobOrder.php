<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class JobOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];
    protected $appends = [
        "status_color", "status_readable",
        "project_name", "job_name", "job_code", "hour_start",
        "employee_total", "employee_active_total", "assessment_count", "assessment_total",
    ];

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

    public function project()
    {
        return $this->belongsTo(ProjectSimple::class, "project_id", "id");
    }

    public function job()
    {
        return $this->belongsTo(Job::class, "job_id", "id");
    }

    public function jobOrderHasEmployees()
    {
        return $this->hasMany(JobOrderHasEmployee::class, "job_order_id", "id");
    }

    public function jobOrderHasStasuses()
    {
        return $this->hasMany(JobOrderHasStatus::class, "job_order_id", "id");
    }

    public function jobOrderAssessments()
    {
        return $this->hasMany(JobOrderAssessment::class, "job_order_id", "id");
    }

    public function getHourStartAttribute()
    {
        return Carbon::parse($this->datetime_start)->format("h:m");
    }

    public function getStatusColorAttribute()
    {
        $statusApprovalLibrary = Config::get("library.status.{$this->status}");

        return $statusApprovalLibrary["color"];
    }

    public function getStatusReadableAttribute()
    {
        $statusApprovalLibrary = Config::get("library.status.{$this->status}");

        return $statusApprovalLibrary["short_readable"];
    }

    public function getProjectNameAttribute()
    {
        if ($this->project) {
            return $this->project->name;
        }
    }

    public function getJobNameAttribute()
    {
        if ($this->job) {
            return $this->job->name;
        }
    }

    public function getJobCodeAttribute()
    {
        if ($this->job) {
            return $this->job->code;
        }
    }

    public function getEmployeeTotalAttribute()
    {
        return 10;
    }

    public function getEmployeeActiveTotalAttribute()
    {
        return 9;
    }

    public function getAssessmentCountAttribute()
    {
        return 1;
    }

    public function getAssessmentTotalAttribute()
    {
        return 2;
    }
}
