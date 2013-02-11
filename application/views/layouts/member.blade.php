<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	@include ('components.header')
	<body>
		@include ('components.nav')
			<div class='container'>
				<div class='app_container'>
					<div class="hero-unit app_content">
						<div class="container-fluid">
							<div class="row-fluid">
								<div class="span1">
									@include ('components.menu')
								</div>
								<div class="span11 app_tin">
									@yield('content')
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@include ('components.footer')
	</body>
</html>