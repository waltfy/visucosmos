@layout('layouts.member')
<? $pagetitle = $details->name; ?>

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
	<h2>{{ $details->name }}  {{ HTML::link('visualisation/edit/'.$details->id, 'Edit', array('class' => 'btn btn-warning')) }}
		@if ($details->json_path != null)
			<small>{{ HTML::link('visualisation/download/'.$details->id, " JSON", array('class' => 'icon-download')) }}</small>
			<small>{{ HTML::link('visualisation/downloadcsv/'.$details->id, " CSV", array('class' => 'icon-download')) }}</a></small>
			<small>{{ HTML::link('#', " IMAGE", array('class' => 'icon-download', 'onclick' => 'generate_svg();')) }}</a></small>
		@endif
	</h2>
	<small>Below you can view the graph you have selected.</small>
	@if ($details->selected_graph != null)
		<div class='col span12' id='graph_place'>
		</div>
		<div class='svg_code hide'>
			<pre>

			</pre>
		</div>
	@endif
<script type="text/javascript">
<? 
	if (Graphs::getFunctionName(unserialize($details->selected_graph)) != null) {
		echo Graphs::getFunctionName(unserialize($details->selected_graph))."('$details->json_path', 'graph_place', 700, 500);";
	};
?>
</script>
@endsection