<?php

namespace App\Http\Controllers;

use App\Models\EmployeePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeChartController extends Controller
{
    public function index()
    {
        return view('EmployeeChart');
    }

    public function getPeriod()
    {
        $periods = DB::table('employee_periods')
            ->select('period')
            ->distinct()
            ->get();

        return response()->json($periods);
    }

    public function getEmployeeCount(Request $request)
    {
        $period = $request->period;
        $selectedTags = $request->tags ?? [];

        $query = EmployeePeriod::query()
            ->where('employee_periods.period', $period);

        if (in_array('Company', $selectedTags)) {
            $query->whereHas('company');
        }
        if (in_array('Level', $selectedTags)) {
            $query->whereHas('level');
        }
        if (in_array('Gender', $selectedTags)) {
            $query->whereHas('gender');
        }
        if (in_array('Division', $selectedTags)) {
            $query->whereHas('division');
        }

        $selectFields = ['period'];
        if (in_array('Company', $selectedTags)) {
            $selectFields[] = 'company_id';
        }
        if (in_array('Level', $selectedTags)) {
            $selectFields[] = 'level_id';
        }
        if (in_array('Gender', $selectedTags)) {
            $selectFields[] = 'gender_id';
        }
        if (in_array('Division', $selectedTags)) {
            $selectFields[] = 'division_id';
        }

        $employees = $query->select($selectFields)
            ->distinct()
            ->get();

        $count = $employees->count();

        return response()->json(['count' => $count, 'employees' => $employees]);
    }
}
