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
			
			$wordCloud = explode(', ', Graphs::where('id', '=', '3')->only('type'));
			$wordCloud2 = explode(', ', Graphs::where('id', '=', '9')->only('type'));
			$barChart = explode(', ', Graphs::where('id', '=', '2')->only('type'));

			// echo "<pre>";
			// print_r($barChart);
			// echo "</pre>";

			$available_graphs = array();

			$dimension = count($types);

			if ($dimension == 1) {

				// WordCloud, 1 Dimension - String
				if (in_array($types[0], $wordCloud)) {
						array_push($available_graphs, '3');
				}

				if (in_array($types[0], $wordCloud2)) {
						array_push($available_graphs, '9');
				}

			}

			if ($dimension == 2) {

				// BarChart, 2 Dimensions - String && Int || String && Float
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
	}

?>