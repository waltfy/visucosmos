<?php

	class Data extends Eloquent {
	
	  public static $timestamps = FALSE;
	  
		public static $table = 'data';

		public function visualisation() {
			return $this->has_many('Visualisation');
		}

		static function validateType($types) {

			echo "<pre>";
			print_r($types);
			echo "</pre>";
			
			$pieChart = explode(', ', Graphs::where('id', '=', '1')->only('type'));
			$barChart = explode(', ', Graphs::where('id', '=', '2')->only('type'));
			$wordCloud = explode(', ', Graphs::where('id', '=', '3')->only('type'));
			$locationPlot = explode(', ', Graphs::where('id', '=', '10')->only('type'));
			$coordPlot = explode(', ', Graphs::where('id', '=', '11')->only('type'));
			$bubbleChart = explode(', ', Graphs::where('id', '=', '12')->only('type'));

			// echo "<pre>";
			// print_r($barChart);
			// echo "</pre>";

			$available_graphs = array();

			$dimension = count($types);

			if ($dimension == 1) {

				// Pie Chart, 1 Dimension - Float || Int
				if (in_array($types[0], $pieChart)) {
					array_push($available_graphs, '1');
				}

				// Bar Chart, 1 Dimension - Float || Int
				if (in_array($types[0], $barChart)) {
					array_push($available_graphs, '2');
				}

				// WordCloud, 1 Dimension - String
				if (in_array($types[0], $wordCloud)) {
					array_push($available_graphs, '3');
				}

				if (in_array($types[0], $locationPlot)) {
					array_push($available_graphs, '10');
				}

				if (in_array($types[0], $bubbleChart)) {
					array_push($available_graphs, '12');
				}

			}

			if ($dimension == 2) {

				if (in_array($types[0], $coordPlot) && in_array($types[1], $coordPlot)) {
					array_push($available_graphs, '11');
				}
				if (in_array($types[0], $barChart) && in_array($types[1], $barChart)) {
					array_push($available_graphs, '2');
				}

			}

			return $available_graphs;
		}
		
		
		public static function saveToDatabase($Input){
			
			$Data_set = new Sets;
			$DS_id = $Data_set->insert_get_id(array('name' => $Input['name']));      
      //Adds csv file to database and server
      //server
      $Files = Input::file('csv');
      if (is_array($Files) && isset($Files['error']) && $Files['error'] == 0) {
        Input::upload('csv',path('storage').'/csv/',$Input['name'].'.csv');
      }
      
      
      //database
      $file = fopen(path('storage').'/csv/'.$Input['name'].'.csv', 'r');
      
      //work arround to fix attr1 layout, could be improved
      while(($data = fgetcsv($file, 0, ',')) !== FALSE){
        
        $Data = new Data();
        $R_id = $Data->insert_get_id(array('attr1' => $data[0], 'data_set_id' => $DS_id)); 
      
        for($l = 1; $l < count($data); $l++){
          $record = $l + 1;
          $Data
          ->where('data_set_id', '=', $DS_id)
          ->where_in('id', array($R_id))
          ->update(array('attr'.$record => $data[$l]));
        }      
        
      }
       
      return $DS_id;
		
	  }
	  
	  public static function labelRow($Input,$Label){
	    
	    if(Input::get('rows') != null){
	      foreach(Input::get('rows') as $row){
	                
	        $SomeData = Data::find($row);
	        $return = $row;
	        $SomeData->line_type =$Label;
	        $SomeData->save();
	     }
	    }
	    	  
	  }
	  
	  public static function generateType($DS_id){
	  
	    $data = Data::where('data_set_id','=',$DS_id)->where('line_type','=','L')->first();
	    
	    $newRow = new Data;
	    
	    $value = $data->attr1;
	    $type = Data::detectType($value);
	      	      
	    $R_id = $newRow->insert_get_id(array('attr1' => $type, 'data_set_id' => $DS_id, 'line_type' => 'T'));
	    
      $value = $data->attr2;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr2' => $type));
      
      $value = $data->attr3;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr3' => $type));
      
      $value = $data->attr4;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr4' => $type));
      
      $value = $data->attr5;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr5' => $type));
      
      $value = $data->attr6;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr6' => $type));
      
      $value = $data->attr7;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr7' => $type));
      
      $value = $data->attr8;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr8' => $type));
      
      $value = $data->attr9;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr9' => $type));
      
      $value = $data->attr10;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr10' => $type));
      
      $value = $data->attr11;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr11' => $type));
      
      $value = $data->attr12;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr12' => $type));
      
      $value = $data->attr13;
      $type = Data::detectType($value);
      $newRow
      ->where('id','=',$R_id)
      ->update(array('attr13' => $type));
        
        
        
        
         
	  }
	  
	  public static function detectType($value){
	  
	  //If structure based on type
	    

	    if(is_numeric($value)){
	
	      $type = 'float';  
	      
	      return $type;
	  
	    }else{
	      
	      $type = gettype($value) ;
	      
        //$types = Data::semanticTest($value, 'Geo');
	      
	      //$types = Data::semanticTest($value, 'Time');
	      
	      if($type == NULL){
	        $type =' ';
	      }
	      
	      
	      return $type;
	    }
	    
	  }
	  
	  public static function semanticTest($value, $type){
	  
	    return false;
	  
	  }
	  
	  
	  
	  
	  
	}

?>