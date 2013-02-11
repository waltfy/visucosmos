<?php
	
	class Settings_Controller extends Base_Controller {
		
		function __construct() {
			parent::__construct();
			$this->filter('before', 'auth');
		}

		function action_index() {
			return View::make('settings.index');
		}

		function action_password() {
			return View::make('settings.password');
		}

	}

?>