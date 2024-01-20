<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Fetch departments and redirect to the create form.
     */
    public function create()
    {
        $departments = Department::all();

        return view('admin.departments.create', compact('departments'));
    }

    /**
     * Store the department in the database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'deptName' => 'required|unique:departments',
            'parent_id' => 'nullable|exists:departments,id',
        ]);

        Department::create($data);

        return redirect()->route('admin.home')->with('success', 'Department created successfully');
    }

    /**
     * Choose which department to edit.
     */
    public function edit(Request $request, $deptName = null)
    {
        $departments = Department::all();

        // Check if the form is submitted
        if ($request->isMethod('post')) {
            // Validate the selected department
            $request->validate([
                'deptName' => 'required|exists:departments,deptName',
            ]);

            // Retrieve the selected department
            $department = Department::where('deptName', $request->input('deptName'))->firstOrFail();

            return view('admin.departments.edit-form', compact('department', 'departments'));
        }

        // Show the initial edit view with the list of departments
        return view('admin.departments.edit', compact('departments'));
    }

    /**
     * Update the database with the changes in the edited department.
     */
    public function update(Request $request, $deptName)
    {
        // Retrieve the selected department
        $department = Department::where('deptName', $deptName)->firstOrFail();

        // Validate the request data
        $data = $request->validate([
            'deptName' => 'required|unique:departments,deptName,' . $department->id,
            'parent_id' => 'nullable|exists:departments,id',
        ]);

        // Update the department details
        $department->update([
            'deptName' => $data['deptName'],
            'parent_id' => $data['parent_id'],
        ]);

        return redirect()->route('admin.home')->with('success', 'Department updated successfully');
    }

    /**
     * Delete a department.
     */
    public function delete(Request $request)
    {
        // If the form is submitted
        if ($request->isMethod('post')) {
            // Validate the selected department
            $request->validate([
                'deptName' => 'required|exists:departments,deptName',
            ]);

            // Retrieve the selected department
            $department = Department::where('deptName', $request->input('deptName'))->firstOrFail();
            $department->delete();

            return redirect()->route('admin.home')->with('success', 'Department deleted successfully');
        }

        // Show the initial delete view with the list of departments
        $departments = Department::all();
        return view('admin.departments.delete', compact('departments'));
    }
}
