<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\EmployeeRepositoryInterface;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        return response()->json($this->employeeRepository->all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:6',
            'nic' => ['required', 'regex:/^([0-9]{9}[vVxX]|[0-9]{12})$/'],
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

        return response()->json($this->employeeRepository->create($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->employeeRepository->find($id));
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
            'nic' => ['sometimes', 'regex:/^([0-9]{9}[vVxX]|[0-9]{12})$/'],
            //'nic' => 'sometimes|string|unique:employees,nic,' . $id,
            'mobile_number' => 'sometimes|string',
        ]);

        if ($request->has('name')) $employee->name = $request->name;
        if ($request->has('email')) $employee->email = $request->email;
        if ($request->has('password')) $employee->password = Hash::make($request->password);
        if ($request->has('nic')) $employee->nic = $request->nic;
        if ($request->has('mobile_number')) $employee->mobile_number = $request->mobile_number;

        $employee->save();

        return response()->json($this->employeeRepository->update($id, $data));
    }

    public function destroy($id)
    {
        $this->employeeRepository->delete($id);
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}

