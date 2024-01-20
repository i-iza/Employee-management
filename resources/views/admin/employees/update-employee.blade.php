@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color:#DAE3D1 ; border-color: #2C3128;">
                    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">{{ __('Update Employee') }}</div>
                    <div class="card-body">
                        <form action="{{ route('admin.employees.update', ['name' => $employee->name]) }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="deptName" class="form-label">Department Name:</label>
                                <input type="text" name="deptName" class="form-control" value="{{ $employee->deptName }}">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary" style="background-color: #7EA951; border-color: #7EA951; color: #FFFFFF;">Update Employee</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
