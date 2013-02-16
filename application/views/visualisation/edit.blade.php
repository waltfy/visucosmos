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
	<h2>{{ $details->name }}<small> @ {{ $dataset->name }}</small> {{ HTML::link('visualisation/delete/'.$details->id, 'Delete', array('class' => 'btn btn-danger')) }}</h2>
	<small>Edit details such as attributes and columns.</small>
	{{ Form::open('data/generate', '', array('class' => 'form-horizontal')) }}
	<div class='col span12'>
		<div class='col span6'>
			{{ Form::label('all_attr', "Pick your attributes.") }}
			<select name='all_attr' id='all_attr' multiple='multiple'>
				<?
					for ( $i = 1; $i < count($attr->attributes)-3; $i++) {
						if ($attr->attributes["attr$i"] == null) {
							break;
						}

						else {
							echo "<option value='attr".$i."'>".$attr->attributes["attr$i"]."</option>";
						}
					}
				?>
			</select>
			<p>{{ HTML::link('#', 'Add', array('class' => 'btn btn-success', 'id' => 'add_attr')) }}</p>
		</div>
		<div class='col span6'>
			{{ Form::label('selected_attr', "Selected attributes.") }}
			<select name='selected_attr[]' id='selected_attr' multiple='multiple'>
			</select>
			<p>{{ HTML::link('#', 'Remove', array('class' => 'btn btn-danger', 'id' => 'rm_attr')) }}</p>
		</div>  
	</div>
	{{ Form::hidden('vis_id', $details->id) }}
	{{ Form::button('Generate Previews', array('class' => 'btn' )) }}
	{{ Form::close() }}
	@if (Session::has('response'))
		<p>Works</p>
		<? echo $response = Session::get('response'); ?>
	@endif
@endsection