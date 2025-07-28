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
            'nic' => ['required', 'regex:/^(\d{9}[vVxX]|\d{12})$/', 'unique:employees,nic'],
            'mobile_number' => ['required', 'regex:/^0\d{9}$/'],
        ]);

        return response()->json($this->employeeRepository->create($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->employeeRepository->find($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
            'nic' => ['required', 'regex:/^(\d{9}[vVxX]|\d{12})$/'],
            'mobile_number' => ['required', 'regex:/^0\d{9}$/'],
        ]);

        return response()->json($this->employeeRepository->update($id, $data));
    }

    public function destroy($id)
    {
        $this->employeeRepository->delete($id);
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}

