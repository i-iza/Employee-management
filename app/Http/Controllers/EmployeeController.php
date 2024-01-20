<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use DataTables;


class EmployeeController extends Controller
{
    /**
     * Show the employees of the selected department.
     */
    public function departmentEmployees(Request $request, $department)
    {
        $employees = User::where('deptName', $department)->get();
        if($request->ajax()){
            $allData = DataTables::of($employees)
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" 
                data-original-title="Edit" class="edit btn btn-primary btn-sm editEmployee" 
                style="background-color: #A6B695; border-color: #A6B695; color: #FFFFFF;">Edit</a>';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" 
                data-original-title="Delete" class="edit btn btn-primary btn-sm deleteEmployee"
                style="background-color: #2C3128; border-color: #2C3128; color: #FFFFFF;">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
            return $allData;
        }
        return view('admin.department-employees', compact('employees', 'department'));
    }

    /**
     * Update the employee's profile details.
     */
    public function update(Request $request, $id)
    {
        User::updateOrCreate(['id' => $id], [
            'name' => $request->name,
            'email' => $request->email,
            'deptName' => $request->deptName,
            'is_admin' => $request->is_admin,
        ]);

        return response()->json(['success' => 'Employee updated successfully.']);
    }

    /**
     * Find the user information based on the id in order to edit it.
     */
    public function edit($id){
        $employees = User::find($id);
        return response()->json($employees);
    }

    /**
     * Delete the given user corresponding to the id.
     */
    public function destroy($id){
        User::find($id)->delete();
        return response()->json(['success'=>'Employee deleted successfully.']);
    }
}
