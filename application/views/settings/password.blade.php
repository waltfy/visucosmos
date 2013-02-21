@layout('layouts.member')
<? $pagetitle = 'Change Password'; ?>

@section('content')
	@if (Session::has('success'))
		<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>Password changed.</p>
		</div>
	@endif
	@if (isset($errors) && count($errors->all()) > 0)
		<div class='alert alert-error'>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<ul>
				@foreach ($errors->all('<li>:message</li>') as $message)
				{{ $message }}
				@endforeach
			</ul>
		</div>
	@endif
	<h2>Change your Password</h2>
	{{ Form::open('settings/changepass', '', array('class' => 'form-horizontal')) }}
	<p>
	{{ Form::label('password', "Enter new password.") }}
	{{ Form::password('password', array('placeholder' => 'Password'))}}
	{{ Form::button('Change Password', array('class' => 'btn btn-success' )) }}
	</p>
	{{ Form::close() }}
@endsection