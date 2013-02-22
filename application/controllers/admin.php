<?php
	
	class Admin_Controller extends Base_Controller {
		
		function __construct() {
			parent::__construct();
			$this->filter('before', 'admin_auth');
		}

		function action_index() {
			return View::make('settings.admin');
		}

		function action_newuser() {
			return View::make('settings.newuser');	
		}

		function action_privileges() {
			return View::make('settings.privileges');	
		}

		function action_upload() {
			return View::make('settings.upload');
		}

		function action_retrieve() {
			return View::make('settings.retrieve');
		}

		function action_redeem($id) {
    	$visualisation = Visualisation::find($id);
    	$visualisation->is_active = 'Y';
    	$visualisation->save();
			return Redirect::to('admin/retrieve')->with('success', true);
		}
		
		function action_storedata(){
	    
	    $Input = Input::all();
	    
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
      
      //creates view   
		  return View::make('settings.dataSet')
		    ->with('Inputs',$Input);
		}

	}

?>