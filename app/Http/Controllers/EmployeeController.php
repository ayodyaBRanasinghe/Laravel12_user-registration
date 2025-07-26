<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:6',
            'nic' => 'required|string|unique:employees,nic',
            'mobile_number' => 'required|string',
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nic' => $request->nic,
            'mobile_number' => $request->mobile_number,
            'ip_address' => $request->ip(), // capture IP
        ]);

        return response()->json($employee, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], Response::HTTP_NOT_FOUND);
        }
        return $employee;
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:employees,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'nic' => 'sometimes|string|unique:employees,nic,' . $id,
            'mobile_number' => 'sometimes|string',
        ]);

        if ($request->has('name')) $employee->name = $request->name;
        if ($request->has('email')) $employee->email = $request->email;
        if ($request->has('password')) $employee->password = Hash::make($request->password);
        if ($request->has('nic')) $employee->nic = $request->nic;
        if ($request->has('mobile_number')) $employee->mobile_number = $request->mobile_number;

        $employee->save();

        return response()->json($employee, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], Response::HTTP_NOT_FOUND);
        }

        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully'], Response::HTTP_OK);
    }
}
