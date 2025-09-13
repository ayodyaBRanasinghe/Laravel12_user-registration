<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewEmployeeService;
use Illuminate\Support\Facades\Log;


class NewEmployeeController extends Controller
{
    protected $newEmployeeService;

    public function __construct(NewEmployeeService $newEmployeeService){
        $this->newEmployeeService = $newEmployeeService;
        Log::info('NewEmployeeController instantiated');
    }


    public function store(Request $request){
        Log::info('Store method called', ['request' => $request->all()]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:new_employees,email',
            'password' => 'required|string|min:6',
            'nic' => 'required|string|unique:new_employees,nic',
            'mobile_number' => 'required|digits:10',
        ]);
        Log::info('Validation passed', ['validated' => $validated]);

        $employee = $this->newEmployeeService->create($validated);
        Log::info('Employee created', ['employee_id' => $employee->id]);

        return response()->json($employee, 201);
    }


    public function show($id){
        $employee = $this->newEmployeeService->getById($id);
        return response()->json($employee);
    }

    public function index()
    {
        return response()->json($this->newEmployeeService->getAll(), 200);
    }


    public function destroy($id){
        $this->newEmployeeService->delete($id);
        return response()->json(['message' => 'Employee deleted successfully']);
    }

    
    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:new_employees,email,' . $id,
            'password' => 'sometimes|nullable|string|min:6',
            'nic' => 'sometimes|required|string|unique:new_employees,nic,' . $id,
            'mobile_number' => 'sometimes|required|digits:10',
        ]);

        $employee = $this->newEmployeeService->update($id, $validated);
        return response()->json($employee);
    }

}
