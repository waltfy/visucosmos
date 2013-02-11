@layout('layouts.member')
<? $pagetitle = 'Dashboard'; ?>

@section('content')
	@if (Session::has('deleted'))
		<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>Visualisation has been deleted.</p>
		</div>
	@endif
	@if (Session::has('not_admin'))
		<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>You must be an administrator to access that area.</p>
		</div>
	@endif
	@if (Session::has('not_admin'))
		<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>You must be an administrator to access that area.</p>
		</div>
	@endif
	<h2>Your Recent Visualisations</h2>
	@if (count($recent) == 0)
		<p>No recent visualisations.</p>
	@else
		<small>The list below displays your latest 5 visualisations.</small>
		@foreach ($recent as $visualisation)	
			<p>{{ HTML::link('visualisation/view/'.$visualisation->id, $visualisation->name); }}</p>
		@endforeach
	@endif
@endsection