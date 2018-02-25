@extends('layouts.master')

@section('title')
    Welcome!
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
    	<div class="col-md-6">
    		<h3>Sign Up</h3>
    		<form action="{{ route('signup') }}" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your E-Mail</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ Request::old('email') }}">
                </div>
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label for="first_name">Your First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ Request::old('first_name') }}">
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Your Password</label>
                    <input type="password" class="form-control" name="password" id="password" value="{{ Request::old('password') }}">
                </div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
    			<button class="btn btn-primary" type="submit" name="submit">Submit</button>
    		</form>	
    	</div>
    	<div class="col-md-6">
    		<h3>Sign In</h3>
    		<form action="{{ route('signin') }}" method="post">
    			<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    				<label for="e-mail">Your E-Mail</label>
    				<input type="text" class="form-control" name="email" id="e-mail" value="{{ Request::old('email') }}">
    			</div>
    			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    				<label for="pass">Your Password</label>
    				<input type="password" class="form-control" name="password" id="pass" value="{{ Request::old('password') }}">
    			</div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
    			<button class="btn btn-primary" type="submit" name="submit">Submit</button>
    		</form>	
    	</div>
    </div>
@endsection