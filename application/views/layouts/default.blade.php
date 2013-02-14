<!DOCTYPE html>
<meta charset="utf-8">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	@include ('components.header')
	<body>
		<div class='container'>
			<div class='app_container'>
				@yield('content')
			</div>
		</div>
		@include ('components.footer')
	</body>
</html>