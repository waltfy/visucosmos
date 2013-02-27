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
	<table>
	@foreach ($Datas as $Data)
	<tr>
	  <td>{{Form::checkbox('rows[]',$Data->id)}} </td>
	  <td>{{$Data->attr1}}</td>
	  <td></td>
	  <td>{{$Data->attr2}}</td>
	  <td></td>
	  <td>{{$Data->attr3}}</td>
	  <td></td>
	  <td>{{$Data->attr4}}</td>
	  <td></td>
	  <td>{{$Data->attr5}}</td>
	  <td></td>
	  <td>{{$Data->attr6}}</td>
	  <td></td>
	  <td>{{$Data->attr7}}</td>
	  <td></td>
	  <td>{{$Data->attr8}}</td>
	  <td></td>
	  <td>{{$Data->attr9}}</td>
	  <td></td>
	  <td>{{$Data->attr10}}</td>
	  <td></td>
	  <td>{{$Data->attr11}}</td>
	  <td></td>
	  <td>{{$Data->attr12}}</td>
	  <td></td>
	  <td>{{$Data->attr13}}</td>
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