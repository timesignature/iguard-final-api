@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                       <h1>Password Reset</h1>
                        <a href="http://localhost:8080/reset/{{$token}}/from_the_king_of_kings">follow this link to reset your password</a>
                        <p>Thank You</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
