<?php

	class Visualisation extends Eloquent {

		public static $table = 'visualisation';

		public function user() {
      return $this->belongs_to('User');
    }

    public static function get_json($id) {
    	return Response::download('public_html/json/'.$id.'.json');
    }

    public static function selectVisualisation($vis_id, $graph_id) {
    	$selected_graph = serialize($graph_id);
    	$visualisation = Visualisation::find($vis_id);
    	$visualisation->selected_graph = $selected_graph;
    	$visualisation->save();
    	return $visualisation;
    }

	}

?>