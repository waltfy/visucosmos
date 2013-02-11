<div class="navbar navbar-static-top">
	<div class="navbar-inner">
		<div class="container">
			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
 
			<!-- Be sure to leave the brand out there if you want it shown -->
			<a class="brand" href="#">VisuCosmos</a>
 
			<!-- Everything you want hidden at 940px or less, place within here -->
			<div class="nav-collapse collapse pull-right">
				<ul class="nav">
					<li>{{ HTML::link('settings', Auth::user()->username) }}</li>
					<li>{{ HTML::link('dashboard/logout', 'Sign Out') }}</li>
				</ul> 
			</div>
		</div>
	</div>
</div>