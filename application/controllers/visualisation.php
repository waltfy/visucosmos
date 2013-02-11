<?php
	
	class Visualisation_Controller extends Base_Controller {
		
		function __construct() {
			parent::__construct();
			$this->filter('before', 'auth');
		}

		function action_index() {
			return View::make('visualisation.index')->with('data_sets', Data::lists('name', 'id'));
		}

		function action_view($id) {
			$details = Visualisation::find($id);
			return View::make('visualisation.view')->with('details', $details);
		}

		function action_edit($id) {
			$details = Visualisation::find($id);
			return View::make('visualisation.edit')->with('details', $details);
		}

		function action_delete($id) {
			$details = Visualisation::find($id);
			$name = $details->name;
			$details->delete();
			return Redirect::to('dashboard')->with('deleted', true);
			// return View::make('dashboard.index');
		}

	}

?>