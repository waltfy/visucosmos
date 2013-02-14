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

	}

?>