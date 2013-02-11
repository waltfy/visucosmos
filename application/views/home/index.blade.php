@layout('layouts.default')
<? $pagetitle = 'Login'; ?>

@section('content')
	<div class="hero-unit login-form">
		@if (Session::has('login_errors'))
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>Username or password incorrect.</p>
			</div>
		@endif
		<h2>VisuCosmos</h2>
		<p>Please enter your login details.</p>
		{{ Form::open('home/signin') }}
		{{ Form::text('username', '', array('placeholder' => 'Username'))}}
		{{ Form::password('password', array('placeholder' => 'Password'))}}
		<div class=''>
			<label class="checkbox">
				{{ Form::checkbox('remember', 'choice', true) }}
				Remember me.
			</label>
		</div>
		{{ Form::button('Login', array('class' => 'btn btn-success btn-large' )) }}
		{{ Form::close();}}
	</div>
@endsection