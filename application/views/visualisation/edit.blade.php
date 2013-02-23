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
	<h2>
		{{ $details->name }}<small> @ {{ $dataset->name }}</small>
		@if ($details->json_path != null)
			<small>{{ HTML::link('visualisation/download/'.$details->id, " Download", array('class' => 'icon-download')) }}</small>
		@endif
		{{ HTML::link('visualisation/delete/'.$details->id, 'Delete', array('class' => 'btn btn-danger')) }}
	</h2>
	<small>Edit details such as attributes and columns.</small>
	{{ Form::open('data/generate', '', array('class' => 'form-horizontal', 'onSubmit' => "selectAllOptions('selected_attr');")) }}
	<div class='col span12'>
		<div class='col span6'>
			{{ Form::label('all_attr', "Pick your attributes.") }}
			<select name='all_attr' id='all_attr' multiple='multiple'>
				<?
					$attr = array_slice($attr, 3);

					foreach($attr as $key => $value) {
						if ($value != null) {
							echo "<option value='$key'>$value</option>";
						}
					}
				?>
			</select>
			<p>{{ HTML::link('#', 'Add', array('class' => 'btn btn-success', 'id' => 'add_attr')) }}</p>
		</div>
		<div class='col span6'>
			{{ Form::label('selected_attr', "Selected attributes.") }}
			<select name='selected_attr[]' id='selected_attr' multiple='multiple'>
				<?
					foreach($saved as $key => $value) {
						echo "<option value='$key'>$value</option>";
					}
				?>
			</select>
			<p>{{ HTML::link('#', 'Remove', array('class' => 'btn btn-danger', 'id' => 'rm_attr')) }}</p>
		</div>  
	</div>
	{{ Form::hidden('vis_id', $details->id) }}
	{{ Form::button('Generate Previews', array('class' => 'btn' )) }}
	{{ Form::close() }}
	<br>
	@if (Session::has('response'))
	<? $response = Session::get('response'); $i = 1; ?>
		<div class='col span12'>
			@foreach ($graphs as $render)
				<div class='col span4' id='render{{$i}}' graphId='{{ $render->id }}'>
						<? echo "<script type='text/javascript'>".$render->attributes['function']."('$response', 'render$i');</script>"; ?>
				</div>
				<? $i++; ?>
			@endforeach
		</div>
	@endif
@endsection