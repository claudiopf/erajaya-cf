<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeePeriod extends Model
{
    use HasFactory;

    protected $table = 'employee_periods';

    protected $fillable = [
        'employee_id',
        'company_id',
        'division_id',
        'level_id',
        'gender_id',
        'period'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
