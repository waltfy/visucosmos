<?php

	class Data_Controller extends Base_Controller {
	
		function __construct() {
			parent::__construct();
			$this->filter('before', 'auth');
		}

		public function action_index() {

		}

		function generate() {
			// Form posts the values desired, and this is redirected from routes.php;
			// You will be passed the attributes and dataset withing an array;

		// 	$dataset = $values['dataset'];
		// 	$properties = $values['attributes']; //There is an array inside the array e.g. array('red' => array('strawberry','apple'),

		// 	//Items passed to this controller username, set, attributes

		// 	$html = array();

		// 	$scalar = DB::table('data') //Selecting the scalar factor for a data set
		// 		->where('set', '=', $dataset)
		// 		->only('scalar');

		// 	$data = DB::table('data') //Selecting the data from the data table into an array
		// 		->where('set', '=', $dataset)
		// 		->get($properties);

		// 	$timesused = DB::table('users') //Selecting the timesused for each user 
		// 		->where('username', '=', $username)
		// 		->only('timesused');

		// 	$availablevis = DB::table('vis') //Selecting the available visualisations according to the scalar
		// 		->where('scalar', '=' $scalar)
		// 		->only('visname'); 

		// 	if($timesused > 10) //If the user has used made more than 10 visualisations
		// 	{
		// 		$usersgraphs = DB::table('users') //Selecting the users previous graphs 
		// 		->where('username', '=', $username) 
		// 		->only('graphs')

		// 		foreach($usersgraphs as $usergraph) //Looping through the users previously used graphs
		// 		{
		// 			if(in_array($availablevis, $usergraph)) //If the user graph is in the available graphs then produce
		// 			{
		// 				$pData = new pData();
		// 				$myData->addPoints($pData);
		// 				$myPicture->new pImage(700,320, $myData);
		// 				$myPicture->setGraphArea(60,40,670,190); 
		// 				$myPicture->drawScale(); //Setting up the pchart
		// 				$functionname = 'draw' . $usergraph . '()'; //Creating the function name
		// 				$myPicture->$functionname();
		// 				$html += $myPicture->Stroke(); //Adding the PNG to the html array
		// 			}
		// 		}
		// 	}
		// 	else
		// 	{

		// 		foreach($availablevis as $graph) //Looping through the available graphs
		// 		{
		// 			$pData = new pData();
		// 			$myData->addPoints($pData);
		// 			$myPicture-> new pImage(700,320, $myData);
		// 			$myPicture-> setGraphArea(60,40,670,190);
		// 			$myPicture->drawScale(); //Setting up the pchart
		// 			$functionname = 'draw' . $graph . '()'; //Creating the function name
		// 			$myPicture->$functionname();
		// 			$html += $myPicture->Stroke(); //Adding the PNG to the html array

		// 		}
		// 	}

		// 	return View::make('output.index')->with('html', $html);
		// }
	}
	
?>