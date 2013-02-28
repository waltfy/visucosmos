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
	    
	    //Action
	    $Input = Input::all();
	    $DS_id = Data::saveToDatabase($Input);
	    
	    //Data for views
	    $Data = Data::where('data_set_id', '=', $DS_id)->get();
	    
	    
		  return View::make('settings.dataSet')
		    ->with('Datas',$Data)
		    ->with('Input', $Input);
		}
		
		function action_markdata(){
			
			//Action
			$Input = Input::all();
			Data::labelRow($Input, 'H');
			
			
			//Data for view
			$Rows = Data::where('data_set_id', '=', $Input['DS_id'])->where('line_type','=','L')->get();
			$Headers = Data::where('data_set_id', '=', $Input['DS_id'])->where('line_type','=','H')->get();

			return View::make('settings.dataLabel')
			->with('Rows', $Rows)
			->with('Headers',$Headers);

		}
		
		function action_detecttype(){
		  //Action
		  $Input = Input::all();

		  Data::generateType($Input['DS_id']);
		
		  //Data for view
		  $Rows = Data::where('data_set_id', '=', $Input['DS_id'])->where('line_type','=','L')->get();
			$Headers = Data::where('data_set_id', '=', $Input['DS_id'])->where('line_type','=','H')->get();
			$Types = Data::where('data_set_id', '=', $Input['DS_id'])->where('line_type','=','T')->get();
			
			return View::make('settings.dataType')
			->with('Rows', $Rows)
			->with('Headers',$Headers)
			->with('Types',$Types);
		
		}

	}

?>