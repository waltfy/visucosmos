@layout('layouts.member')
<? $pagetitle = 'Create New'; ?>

@section('content')
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
	<h2>New Visualisation</h2>
	<small>Create a new visualisation from the Cosmos API.</small>
	{{ Form::open('visualisation/new', '', array('class' => 'form-horizontal')) }}
	<p>
	{{ Form::label('name', "Name your visualisation.") }}
	{{ Form::text('name', '', array('placeholder' => 'Visualisation Name')) }}
	</p>
	<p>
	{{ Form::label('data-set', "Select a Data Set below.") }}
	{{ Form::select('data-set', $select, Input::old('id')) }}
	</p>
	{{ Form::button('Create', array('class' => 'btn btn-success' )) }}
	
	{{ Form::close() }}
@endsection