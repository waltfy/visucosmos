<?php
	
	class Visualisation_Controller extends Base_Controller {
		
		function __construct() {
			parent::__construct();
			$this->filter('before', 'auth');
		}

		function action_index() {
			return View::make('visualisation.index')->with('select', Data::lists('name', 'id'));
		}

		function action_view($id) {
			$details = Visualisation::find($id);
			$dataset = Data::find($details->data_set_id);
			return View::make('visualisation.view')->with('details', $details)->with('dataset', $dataset);
		}

		function action_edit($id) {
			$details = Visualisation::find($id);
			$dataset = Data::find($details->data_set_id);

			$attr = Data::lists('name');
			return View::make('visualisation.edit')->with('details', $details)->with('dataset', $dataset)->with('select', $attr);
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