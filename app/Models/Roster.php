<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Roster extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];
    protected $appends = ["roster_status_initial", "roster_status_color"];

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

    public function rosterStatus()
    {
        return $this->belongsTo(RosterStatus::class, "roster_status_id", "id");
    }

    public function getRosterStatusInitialAttribute()
    {
        if ($this->rosterStatus) {
            return $this->rosterStatus->initial;
        }
    }

    public function getRosterStatusColorAttribute()
    {
        if ($this->rosterStatus) {
            return $this->rosterStatus->color;
        }
    }
}
