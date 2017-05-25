@extends('layouts.master')

@section('title','Login & Register')


@section('content')

<div class="container" id="login-register">
	<div class="row">
        @include('layouts.messages')
        
        <div class="col-md-5">
            <h2>Login</h2>
            <form action="{{route('login')}}" method="post">
                <input name="email" class="form-control" placeholder="Email" value="{{ Request::old('email') }}">
                <input name="password" type="password" class="form-control" placeholder="Password">
                <button type="submit" class="btn btn-default">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
            <h3>Or Use:</h3>
            <a href="{{route('login-provider','facebook')}}"><i class="fa fa-facebook-square"></i></a>
            <a href="{{route('login-provider','twitter')}}"><i class="fa fa-twitter-square"></i></a>
            <a href="{{route('login-provider','google')}}"><i class="fa fa-google"></i></a>
        </div>
        
        <div class="col-md-2">
            <img class="img-responsive" src="{{ URL::to('images/Login-Register/or.png') }}" alt="loading..." />
        </div>

        <div class="col-md-5">
            <h2>Register</h2>
            <form action="{{route('register')}}" method="post">
                <input name="name" class="form-control" placeholder="Name" value="{{ Request::old('name') }}">
                <input name="email" class="form-control" placeholder="Email" value="{{ Request::old('email') }}">
                <input name="password" type="password" class="form-control" placeholder="Password">
                <button type="submit" class="btn btn-default">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>

	</div>
</div>

@endsection