<div class="navbar navbar-static-top">
	<div class="navbar-inner">
		<div class="container">
			<!-- Be sure to leave the brand out there if you want it shown -->
			<a class="brand" href="#">VisuCosmos</a>
 
			<!-- Everything you want hidden at 940px or less, place within here -->
			<div class="nav pull-right">
				<ul class="nav">
					<li>{{ HTML::link('settings', Auth::user()->username) }}</li>
					<li>{{ HTML::link('dashboard/logout', 'Sign Out') }}</li>
				</ul> 
			</div>
		</div>
	</div>
</div>