@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color:#DAE3D1 ; border-color: #2C3128;">
                    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">{{ __('User Profile') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <p style="color: #2C3128;">Name: {{ $user->name }}</p>
                                <p style="color: #2C3128;">Email: {{ $user->email }}</p>
                                @if ($user->deptName)
                                    <p style="color: #2C3128;">Department: {{ $user->deptName }}</p>
                                @endif
                            </div>
                            <div class="col-md-6 text-end">
                                @if ($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" style="max-width: 200px; height: auto; border-radius: 8px;">
                                @endif
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
