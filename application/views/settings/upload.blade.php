@layout('layouts.member')
<? $pagetitle = 'New Data Set'; ?>

@section('content')
	@if (Session::has('add_success'))
		<div class="alert alert-sucess">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>Data Set Uploaded Successfully.</p>
		</div>
	@endif
	@if (Session::has('remove_success'))
		<div class="alert alert-sucess">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>Upload Failed.</p>
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
	<h2>Add Data Set</h2>
	{{ Form::open('settings/add_admin', '', array('class' => 'form-horizontal')) }}
	<p>
	{{ Form::label('name', "Enter a data set name.") }}
	{{ Form::text('name', '', array('placeholder' => 'Twitter Data'))}}
	</p>
	<p>
	{{ Form::label('description', "Enter a data set name.") }}
	{{ Form::textarea('description', '', array('placeholder' => 'Twitter Data', 'rows' => '3'))}}
	</p>
	<p>
	{{ Form::file('csv') }}
	</p>
	{{ Form::hidden('current_user', Auth::user()->username ) }}
	{{ Form::button('Upload', array('class' => 'btn btn-success' )) }}
	{{ Form::close() }}
@endsection