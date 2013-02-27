@layout('layouts.member')
<? $pagetitle = 'Settings'; ?>

@section('content')
	<h2></h2>
	{{Form::open('settings/detect_type', 'POST', array('class' => 'form-horizontal'))}}
	<small>
	
	<table>
	@foreach ($Headers as $Data)
	<tr>
	  <th>{{$Data->attr1}}</th>
	  <th></th>
	  <th>{{$Data->attr2}}</th>
	  <th></th>
	  <th>{{$Data->attr3}}</th>
	  <th></th>
	  <th>{{$Data->attr4}}</th>
	  <th></th>
	  <th>{{$Data->attr5}}</th>
	  <th></th>
	  <th>{{$Data->attr6}}</th>
	  <th></th>
	  <th>{{$Data->attr7}}</th>
	  <th></th>
	  <th>{{$Data->attr8}}</th>
	  <th></th>
	  <th>{{$Data->attr9}}</th>
	  <th></th>
	  <th>{{$Data->attr10}}</th>
	  <th></th>
	  <th>{{$Data->attr11}}</th>
	  <th></th>
	  <th>{{$Data->attr12}}</th>
	  <th></th>
	  <th>{{$Data->attr13}}</th>
	</tr>
	@endforeach
	
	
	@foreach ($Rows as $Data)
	<tr>
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

@endsection