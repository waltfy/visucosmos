@layout('layouts.member')
<? $pagetitle = 'Add Privilege'; ?>

@section('content')
	@if (Session::has('add_success'))
		<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>User is now an administrator.</p>
		</div>
	@endif
	@if (Session::has('remove_success'))
		<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>User is not an administrator anymore.</p>
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
	<h2>Add Privilege</h2>
	{{ Form::open('settings/add_admin', '', array('class' => 'form-horizontal')) }}
	<p>
	{{ Form::label('username', "Enter user's student number.") }}
	{{ Form::text('username', '', array('placeholder' => 'c1xx1xx8'))}}
	{{ Form::hidden('current_user', Auth::user()->username ) }}
	{{ Form::button('Add Privilege', array('class' => 'btn btn-success' )) }}
	</p>
	{{ Form::close() }}

	<h2>Remove Privilege</h2>
	{{ Form::open('settings/rm_admin', '', array('class' => 'form-horizontal')) }}
	<p>
	{{ Form::label('username', "Enter user's student number.") }}
	{{ Form::text('username', '', array('placeholder' => 'c1xx1xx8'))}}
	{{ Form::hidden('current_user', Auth::user()->username ) }}
	{{ Form::button('Remove Privilege', array('class' => 'btn btn-danger' )) }}
	</p>
	{{ Form::close() }}
@endsection