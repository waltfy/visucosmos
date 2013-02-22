<?php
	
	class Visualisation_Controller extends Base_Controller {
		
		function __construct() {
			parent::__construct();
			$this->filter('before', 'auth');
		}

		function action_index() {
			return View::make('visualisation.index')->with('select', Sets::lists('name', 'id'));
		}

		function action_view($id) {
			$details = Visualisation::find($id);
			$dataset = Sets::find($details->data_set_id);
			return View::make('visualisation.view')->with('details', $details)->with('dataset', $dataset);
		}

		function action_edit($id) {

			$visualisations = User::find(Auth::user()->id)->visualisation()->get('id');
			$owns = array();

			foreach ($visualisations as $visu) {
				array_push($owns, $visu->attributes['id']);
			}

			if (in_array($id, $owns)) {
				
				$details = Visualisation::find($id);
				$dataset = Sets::find($details->data_set_id);
				$saved_params = unserialize($details->params);
				$graphs = unserialize($details->available_graphs);

				if ($details->available_graphs != null && $graphs != null) {
					$available_graphs = Graphs::where_in('id', $graphs)->get();
				}

				else {
					$available_graphs = array();
				}

				$attr = Data::where('data_set_id', '=', $details->data_set_id)->where('line_type', '=', 'H')->first();

				if ($saved_params != null) {
					$saved = Data::where('data_set_id', '=', $details->data_set_id)->where('line_type', '=', 'H')->first($saved_params);	
					$saved = $saved->attributes;
				}

				else {
					$saved = array();
				}
				
				$attr = $attr->attributes;
				$available = array_diff($attr, $saved);
				return View::make('visualisation.edit')->with('details', $details)->with('dataset', $dataset)->with('attr', $available)->with('saved', $saved)->with('graphs', $available_graphs);
			}

			else {
				return Redirect::to('dashboard')->with('not_owner', true);
			}

		}

		function action_download($id) {
			return Visualisation::get_json($id);
		}

		function action_delete($id) {
			$details = Visualisation::find($id);
			$name = $details->name;
			$details->is_active = 'N';
			$details->save();
			return Redirect::to('dashboard')->with('deleted', true);
		}

	}

?>