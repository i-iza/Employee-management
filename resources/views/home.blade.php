@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color:#DAE3D1 ; border-color: #2C3128;">
                    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        {{ __('You are logged in!') }}
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
