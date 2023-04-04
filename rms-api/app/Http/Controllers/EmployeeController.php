<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $employees = new Employee([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);
        $employees->save();
        return response()->json('Employee created!');
    }
}
