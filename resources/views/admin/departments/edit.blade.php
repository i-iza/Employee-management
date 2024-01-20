@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color:#DAE3D1 ; border-color: #2C3128;">
                    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">{{ __('Choose Department') }}</div>
                    <div class="card-body">
                        <form action="{{ route('admin.departments.edit') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="deptName" class="form-label">Select Department to Edit:</label>
                                <select class="form-select" name="deptName" id="deptName">
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->deptName }}">{{ $dept->deptName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color: #7EA951; border-color: #7EA951; color: #FFFFFF;">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
