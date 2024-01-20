@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color:#DAE3D1 ; border-color: #2C3128;">
                    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">{{ __('Edit Department') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h4>{{ $department->deptName }}</h4>
    
                        <form action="{{ route('admin.departments.update', $department->deptName) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="mb-3">
                                <label for="deptName" class="form-label">Department Name:</label>
                                <input type="text" class="form-control" name="deptName" value="{{ old('deptName', $department->deptName) }}" required>
                                @error('deptName')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Department:</label>
                                <select class="form-select" name="parent_id" id="parent_id">
                                    <option value="" selected>Select Parent Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ $dept->id == old('parent_id', $department->parent_id) ? 'selected' : '' }}>
                                            {{ $dept->deptName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary" style="background-color: #7EA951; border-color: #7EA951; color: #FFFFFF;">Update Department</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
