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

<?php  
	// // Standard inclusions     
	// include("pChart/class/pData.class.php");
	// include("pChart/class/pChart.class.php");
	  
	// // Dataset definition   
	// $DataSet = new pData;  
	// $DataSet->AddPoint(array(1,4,3,2,3,3,2,1,0,7,4,3,2,3,3,5,1,0,7));  
	// $DataSet->AddSerie();  
	// $DataSet->SetSerieName("Sample data","Serie1");  
	  
	// // Initialise the graph  
	// $Test = new pChart(700,230);  
	// $Test->setFontProperties("Fonts/tahoma.ttf",10);  
	// $Test->setGraphArea(40,30,680,200);  
	// $Test->drawGraphArea(252,252,252);  
	// $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);  
	// $Test->drawGrid(4,TRUE,230,230,230,255);  
	  
	// // Draw the line graph  
	// $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());  
	// $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);  
	  
	// // Finish the graph  
	// $Test->setFontProperties("Fonts/tahoma.ttf",8);  
	// $Test->drawLegend(45,35,$DataSet->GetDataDescription(),255,255,255);  
	// $Test->setFontProperties("Fonts/tahoma.ttf",10);  
	// $Test->drawTitle(60,22,"My pretty graph",50,50,50,585);  
	// $Test->Render("Naked.png");  
?>
@endsection