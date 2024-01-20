<style>
    .tree ul li a {
        color: #2C3128 !important;
        font-size: 16px;
        text-decoration: none;
    }
</style>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color:#DAE3D1 ; border-color: #2C3128;">
                    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">{{ __('Administrator Home') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="column">
                            <div class="col-md-20">
                                <h3 style="color: #2C3128;">{{ __('Department List') }}</h3>
                                <!-- Link to create a new department -->
                                <a href="{{ route('admin.departments.create') }}" class="btn btn-primary" style="background-color: #7EA951; border-color: #7EA951; color: #FFFFFF;">Create New Department</a>

                                <!-- Single Edit button -->
                                <a href="{{ route('admin.departments.edit') }}" class="btn btn-warning" style="background-color: #A6B695; border-color: #A6B695; color: #FFFFFF;">Edit Department</a>

                                <!-- Button to redirect to delete view -->
                                <a href="{{ route('admin.departments.delete') }}" class="btn btn-danger" style="background-color: #2C3128; border-color: #2C3128; color: #FFFFFF;">Delete Department</a>
                            </div>
                        </div>
                        <hr>
                        <div class="tree">
                            <ul style="list-style-type: none; padding-left: 10px; color: #7EA951;">
                                @foreach ($tree as $department)
                                    @include('admin.department-view', ['department' => $department])
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Chat Container -->
                    <div class="card-footer">
                        @include('chat-container', ['messages' => $messages])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
