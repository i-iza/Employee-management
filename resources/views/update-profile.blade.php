@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color:#DAE3D1 ; border-color: #2C3128;">
                    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">{{ __('Update Profile Information') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="column">
                            <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="deptName" class="form-label">Department:</label>
                                    <input type="text" class="form-control" name="deptName" value="{{ $user->deptName }}">
                                </div>

                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Profile Picture:</label>
                                    <input type="file" class="form-control" name="profile_picture">
                                </div>

                                <button type="submit" class="btn btn-primary" style="background-color: #7EA951; border-color: #7EA951; color: #FFFFFF;">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
@endsection
