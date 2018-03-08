@extends('master_login')
@section('title', 'My Blog-Login')
@section('main') 
<body class="login-body">
<div class="container">	
    <div class="form-signin">
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">My Blog</h1>
        </div>
        <div class="login-wrap">
			<form method='post' action='/loginme'>
				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
				@endif
				@if (session('warning'))
					<div class="alert alert-danger">{{ session('warning') }}</div>
				@endif
				@if (session('success'))
					<div class="alert alert-success">{{ session('success') }}</div>
				@endif
				<input type='hidden' name='_token' value="{{ csrf_token() }}" />
				<input type="text" class="form-control" placeholder="Username" name="useremail" autofocus>
				<input type="password" class="form-control" placeholder="Password" name="password">				
				<input type='submit' name='submit' value='Login' class='btn btn-lg btn-login btn-block'/>
			</form>
        </div>
    </div>
</div>
@endsection