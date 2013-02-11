<?php
	
	class Dashboard_Controller extends Base_Controller {
		
		function __construct() {
			parent::__construct();
			$this->filter('before', 'auth');
		}

		function action_index() {
			$recent = User::find(Auth::user()->id)->visualisation()->order_by('created_at', 'desc')->take(5)->get();
			return View::make('dashboard.index')->with('recent', $recent);
		}

		function action_logout() {
			Auth::logout();
			return Redirect::to('home');
		}

		function action_test() {

			$csv = file_get_contents( '/Users/waltercarvalho/Downloads/teamgb-raw-july-august-2012.csv' );
			$csv = explode("\n", trim($csv) );
			
			foreach ( $csv as &$line ){
				$line = trim( $line );
			}
			
			print json_encode($csv);

		}

	}

?>