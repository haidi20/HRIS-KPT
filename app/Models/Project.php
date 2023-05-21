<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Project extends Model
{
    use HasFactory, SoftDeletes;

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

    public function barge()
    {
        return $this->belongsTo(Barge::class, "barge_id", "id");
    }

    public function company()
    {
        return $this->belongsTo(Company::class, "company_id", "id");
    }

    public function job()
    {
        return $this->belongsTo(Job::class, "job_id", "id");
    }

    public function foreman()
    {
        return $this->belongsTo(Employee::class, "foreman_id", "id");
    }

    public function contractors()
    {
        return $this->hasMany(ContractorHasParent::class, "parent_id", "id")
            ->where("parent_model", "App\Models\Project");
    }

    public function ordinarySeamans()
    {
        return $this->hasMany(OrdinarySeamanHasParent::class, "parent_id", "id")
            ->where("parent_model", "App\Models\Project");
    }
}
