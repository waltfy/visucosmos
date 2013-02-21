@layout('layouts.member')
<? $pagetitle = 'New User'; ?>

@section('content')
	@if (Session::has('success'))
		<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>User has been added successfully.</p>
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
	<h2>Add New User</h2>
	{{ Form::open('admin/register', '', array('class' => 'form-horizontal')) }}
	<p>
	{{ Form::label('username', "Enter user's student number.") }}
	{{ Form::text('username', '', array('placeholder' => 'c1xxx9xx'))}}
	</p>
	{{ Form::label('email', "Enter the user's email.") }}
	{{ Form::email('email', '', array('placeholder' => 'newuser@email.com'))}}
	{{ Form::button('Add User', array('class' => 'btn btn-success' )) }}
	{{ Form::close() }}
@endsection