<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;


class StudentController extends Controller
{
    // List all Students
    public function index()
    {
        return Student::all();
    }

    // Create a Student
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:6',
        ]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($student, Response::HTTP_CREATED);
    }

    // Show a single student by ID
    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($student, Response::HTTP_OK);
    }

    // Update a student by ID
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:students,email,' . $id,
            'password' => 'sometimes|string|min:6',
        
        ]);

        if ($request->has('name')) $student->name = $request->name;
        if ($request->has('email')) $student->email = $request->email;
        if ($request->has('password')) $student->password = Hash::make($request->password);

        $student->save();

        return response()->json($student, Response::HTTP_OK);
    }

    // Delete a student by ID
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        $student->delete();

        return response()->json(['message' => 'Student deleted successfully'], Response::HTTP_OK);
    }
}