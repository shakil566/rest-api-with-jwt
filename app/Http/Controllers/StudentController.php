<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::all();
        return response()->json(['message' => 'All students', 'status' => 200, 'data' => $student]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:students|max:255',
            'email' => 'required|email|unique:students',
        ]);

        $student = Student::insert($request->all());
        if($student){
            return response()->json(['message' => 'Student created', 'status' => 201]);
        }else {
            return response()->json(['message' => 'Student not created', 'status' => 401]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if($student){
            return response()->json(['message' => 'Student available', 'status' => 201, 'data' => $student]);
        }else {
            return response()->json(['message' => 'Student not found', 'status' => 401, 'data' => $student]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [];

        $validated = $request->validate([
            'name' => 'required|max:255|unique:students,name,'.$id,
            'email' => 'required|email|unique:students,email,'.$id,
        ]);


        $student = Student::find($id);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        if(!empty($student)){
            $update = $student->update($data);
        }else {
            return response()->json(['message' => 'Student not found', 'status' => 401, 'data' => $student]);
        }
        if($update){
            return response()->json(['message' => 'Student updated', 'status' => 201]);
        }else {
            return response()->json(['message' => 'Student not updated', 'status' => 401]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        if(!empty($student)){
            $delete = $student->delete();
        }else {
            return response()->json(['message' => 'Student not found', 'status' => 401, 'data' => $student]);
        }
        if($delete){
            return response()->json(['message' => 'Student deleted', 'status' => 201]);
        }else {
            return response()->json(['message' => 'Student not deleted', 'status' => 401]);
        }
    }
}
