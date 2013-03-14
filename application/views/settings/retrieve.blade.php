@layout('layouts.member')
<? $pagetitle = 'Add Privilege'; ?>

@section('content')
	@if (Session::has('no_vis'))
		<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>No visualisations available for retrieval.</p>
		</div>
	@endif
	@if (Session::has('success'))
		<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>Visualisation retrieved successfully.</p>
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
	<h2>Retrieve Visualisation</h2>
	<small>Retrieve a deleted visualisation.</small>
	{{ Form::open('settings/getback', '', array('class' => 'form-horizontal')) }}
	<p>
	{{ Form::label('username', "Enter user's student number.") }}
	{{ Form::text('username', '', array('placeholder' => 'c1xx1xx8'))}}
	{{ Form::button('Retrieve', array('class' => 'btn btn-success' )) }}
	</p>
	{{ Form::close() }}
	<br>
	@if (Session::has('retrieved'))
		<?php $retrieved =  Session::get('retrieved'); ?>
		<table class="table table-hover">
			<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Created At</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
				@foreach ($retrieved as $data)
					<tr>
						<td>{{ $data->id }}</td>
						<td>{{ $data->name }}</td>
						<td>{{ $data->created_at }}</td>
						<td>{{ HTML::link('admin/redeem/'.$data->id, 'Redeem'); }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@endsection