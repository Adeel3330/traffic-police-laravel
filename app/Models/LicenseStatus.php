<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseStatus extends Model
{
    protected $table = 'dlms_license_status'; 
    protected $fillable = [
        'ApplicantName',
        'CNIC',
        'LicenseType',
        'LearnerNumber',
        'LicenseNumber',
        'issue_date',
        'expire_date',
        'address',
        'Status'
    ];
}
