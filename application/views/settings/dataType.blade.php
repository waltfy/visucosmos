@layout('layouts.member')
<? $pagetitle = 'Settings'; ?>

@section('content')
	{{Form::open('settings/data_finish', 'POST', array('class' => 'form-horizontal'))}}
	<small>
	
	<table class="table">
	@foreach ($Headers as $Data)
	<thead>
	<tr>
	<?php
		for($l = 1; $l <= 14; $l++){
			$attr = "attr".$l;
			echo'<th>'.$Data->$attr.'</th>'; 
		}
	?>
	</tr>
	</thead>
	@endforeach
	
	
	@foreach ($Rows as $Data)
	<tr>
		<?php
		for($l = 1; $l <= 14; $l++){
			$attr = "attr".$l;
			echo'<td>'.$Data->$attr.'</td>'; 
		}
		?>
	</tr>
	{{ Form::hidden('DS_id', $Data->data_set_id ) }}
	@endforeach
	
	@foreach ($Types as $Data)
	<tr>
		<?php
		for($l = 1; $l <= 14; $l++){
			$attr = "attr".$l;
			echo'<td><i>'.$Data->$attr.'</i></td>'; 
		}
		?>
	</tr>
	@endforeach
	
	
	</table>
	</small>
	</br>
	{{ Form::button('Finish', array('class' => 'btn btn-success' )) }}
	{{Form::close()}}

@endsection