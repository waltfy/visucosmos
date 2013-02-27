<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>VisuCosmos - {{ $pagetitle }}</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{{ HTML::script('js/vendor/modernizr-2.6.1.min.js'); }}
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.0.min.js"><\/script>')</script>
	{{ HTML::script('http://d3js.org/d3.v3.min.js') }}
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/main.css') }}
	{{ HTML::style('css/font-awesome.css') }}
	{{ HTML::style('css/bootstrap-responsive.css') }}
	{{ HTML::script('js/d3.layout.cloud.js')}}
	{{ HTML::script('js/main.js')}}
	{{ HTML::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyAisD4YF47Qpu_VBhq9wUb6lbIAH61816Y&sensor=false') }}
</head>