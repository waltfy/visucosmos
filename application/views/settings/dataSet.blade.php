@layout('layouts.member')
<? $pagetitle = 'Settings'; ?>

@section('content')
	<h2>New Data Set</h2>
	<h3>Title</h3>
	<small>{{$DS_id}}</small>
	<h3>Description</h3>
	<small>{{$DS_id}}</small>
	
	<h3>Sample File Contents</h3>
	
	<br>
@endsection