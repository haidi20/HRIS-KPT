<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Employee extends Model
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

    public function position()
    {
        return $this->belongsTo(Position::class, "position_id", "id");
    }

    public function departmen()
    {
        return $this->belongsTo(Departmen::class, "departmen_id", "id");
    }

    public function employee_type()
    {
        return $this->belongsTo(EmployeeType::class, "employee_type_id", "id");
    }

    public function location()
    {
        return $this->belongsTo(Location::class, "location_id", "id");
    }
}
