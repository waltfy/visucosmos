@layout('layouts.member')
<? $pagetitle = 'Settings'; ?>

@section('content')
	<h2>New Data Set</h2>
	<h3>Title</h3>
	<small>{{$Input['name']}}</small>
	<h3>Description</h3>
	<small>{{$Input['description']}}</small>
	
	<h3>File Contents</h3>
	<small><i>Please select rows to be marked as a 'Header'.</i></small>
	<br>
	
	{{Form::open('settings/mark_data', 'POST', array('class' => 'form-horizontal'))}}
	<small>
	<table class ="table table-hover">
	@foreach ($Datas as $Data)
	<tr>
	  <td>{{Form::checkbox('rows[]',$Data->id)}} </td>
	  <?php
		for($l = 1; $l <= 14; $l++){
			$attr = "attr".$l;
			echo'<td>'.$Data->$attr.'</td>'; 
		}
		?>

	</tr>
	{{ Form::hidden('DS_id', $Data->data_set_id ) }}
	@endforeach
	</table>
	</small>
	</br>
	{{ Form::button('Update', array('class' => 'btn btn-success' )) }}
	{{Form::close()}}
	  
	
	<br>
@endsection