@layout('layouts.member')
<? $pagetitle = 'Edit Visualisation'; ?>

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
	<h2>{{ $details->name }}<small> @ {{ $dataset->name }}</small></h2>
	<small>Edit details such as attributes and columns.</small>
	{{ Form::open('data/generate', '', array('class' => 'form-horizontal')) }}
	<p>
	{{ Form::label('cols', "Pick your columns.") }}
	{{ Form::select('attributes', $select, null, array('multiple' => 'multiple')) }}
	</p>
	<p>

	</p>
	{{ HTML::link('visualisation/delete/'.$details->id, 'Delete', array('class' => 'btn btn-danger')) }}
	{{ Form::button('Generate Previews', array('class' => 'btn btn-success' )) }}
	
	{{ Form::close() }}
@endsection