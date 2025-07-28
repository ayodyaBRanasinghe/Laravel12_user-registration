<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function all()
    {
        return Employee::all();
    }

    public function find($id)
    {
        return Employee::findOrFail($id);
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return Employee::create($data);
    }

    public function update($id, array $data)
    {
        $employee = Employee::findOrFail($id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $employee->update($data);
        return $employee;
    }

    public function delete($id)
    {
        return Employee::destroy($id);
    }
}

