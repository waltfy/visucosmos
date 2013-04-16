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
	<h2>{{ $details->name }}  {{ HTML::link('visualisation/edit/'.$details->id, 'Edit', array('class' => 'btn btn-warning')) }}</h2>
	<small>Below you can view the graph you have selected.</small>
	@if ($details->selected_graph != null)
		<div id='graph_place' class='col span12'>
			<script type='text/javascript'>
			<? echo Graphs::getFunctionName(unserialize($details->selected_graph))."('$details->json_path', 'graph_place', 700, 500);"; ?>
			</script>
		</div>
	@endif

<script type="text/javascript">
	var canvas = document.getElementById("test");

	console.log(canvas);
	
	var img = canvas.toDataURL("image/png");
	
	document.write('<img src="'+img+'"/>');
</script>

<?php   
	// include("pChart/class/pDraw.class.php"); 
	// include("pChart/class/pImage.class.php"); 
	// include("pChart/class/pData.class.php");
	
	// $sent = Input::all(); //Collecting all of the input
	// $titles = $sent->titles; 
	// $data = $sent->data;
	// $availgraphs = $sent->availgraphs;

	// //Creating the visualistions
	// $DataSet = newPdata();
	// for ($i = 0; $i <= count($data); $i++) {//Looping through the columns in order to add the points
	// 	$DataSet->addPoints($data[i]);
	// 	$DataSet->AddSerie();  
	// 	$DataSet->SetSerieName("Sample data");
	// }  

	// $Picture = new pImage(700,230,$DataSet); //Creating a PChart object and associating it with the DataSet
	// $Picture->setGraphArea(60,40,670,190); //Defining the chart area boundaries
	// $Picture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11)); //Setting the graphs font 

	// $myPicture->drawScale();
	// foreach ($availgraphs as $graph) {
	// 	$functionname = 'draw' . $graph . '()'; //Attempting to re-create a format along the lines of myPicture->drawSplineChart();
	// 	$myPicture->$functionname; //Running the function
	// 	echo "<div class = 'visbox'>";
	// 	$myPicture->Stroke();
	// 	echo "</div>";
	// }

?>
@endsection