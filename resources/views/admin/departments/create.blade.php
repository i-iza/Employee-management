@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color:#DAE3D1 ; border-color: #2C3128;">
                    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">{{ __('Create New Department') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.departments.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="deptName" class="form-label">{{ __('Department Name') }}</label>
                                <input type="text" class="form-control @error('deptName') is-invalid @enderror" id="deptName" name="deptName" value="{{ old('deptName') }}" required>
                                @error('deptName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="parent_id" class="form-label">{{ __('Parent Department') }}</label>
                                <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                    <option value="" selected>Select Parent Department (optional)</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept['id'] }}">{{ $dept['deptName'] }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color: #7EA951; border-color: #7EA951; color: #FFFFFF;">{{ __('Create Department') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
