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

		function action_downloadcsv($id) {
			$json_str = Visualisation::get_json($id);

			$array = json_decode($json_str);
			$newarray = array();
			$firstvalue = ""; 

			$newarray = array(); 
			foreach ($array as $key => $jsons) { // This will search in the 2 jsons
     			foreach($jsons as $key => $value) {
         			echo $key; 
         			echo " , ";
         			echo $value;
         			echo "<br/>";
    			}
			}

 			header("Content-type: text/csv");  
			header("Cache-Control: no-store, no-cache");  
			header('Content-Disposition: attachment; filename="filename.csv"'); 
			 

		}

		function action_save($vis_id, $graph_id) {
			$visualisation = Visualisation::selectVisualisation($vis_id, $graph_id);
			// print_r($visualisation);
			return Redirect::to('visualisation/view/'.$vis_id);
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