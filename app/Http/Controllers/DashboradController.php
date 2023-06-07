<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboradController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        $employeeID = Auth::user()->employee_id;

        $vehicleID = Vehicle::where('employee_id', $employeeID)->first();
        
        $employeeInfo = Employee::select('employees.*', 'ejt.name AS job_title')
            ->leftJoin('employee_job_titles AS ejt', 'ejt.id', '=', 'employees.job_title_id')    
            ->where('employees.id', $employeeID)
            ->first();

        if (!empty($employeeInfo->job_title) && $employeeInfo->job_title == 'Driver') {
            return redirect()->route('bicozumExpress.scheduledTransportationVehicle', ['vehicle_id' => $vehicleID]);
        }


        return view('dashboard', compact('title'));
    }
}
