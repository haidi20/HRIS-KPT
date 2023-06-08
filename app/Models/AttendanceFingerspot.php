<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceFingerspot extends Model
{
    use HasFactory;

    protected $fillable = [
        'pin',
        'scan_date',
        'cloud_id',
        'verify',
        'status_scan',
    ];
}
