<?php

	class Data extends Eloquent {
	
	  public static $timestamps = FALSE;
	  
		public static $table = 'data';

		public function visualisation() {
			return $this->has_many('Visualisation');
		}

		static function validateType($types) {
			
			$available_graphs = array();

			$dimension = count($types);

			if ($dimension == 1) {

				if ($types[0] == 'string') {
					$graphs = Graphs::where('type', '=', 'string')->get('id');

					foreach ($graphs as $value) {
						array_push($available_graphs, $value->attributes['id']);
					}
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