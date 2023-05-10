<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = Schema::getColumnListing($this->getTable());
    }

    public function company()
    {
        return $this->belongsTo(Company::class, "company_id", "id");
    }

    public function barge()
    {
        return $this->belongsTo(Barge::class, "barge_id", "id");
    }
}
