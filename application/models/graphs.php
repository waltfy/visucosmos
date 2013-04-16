<?php

	class Graphs extends Eloquent {

		public static $table = 'graphs';

		public function visualisation() {
			return $this->has_many('Visualisation');
		}

		public static function getFunctionName($graph_id) {
			$graph = Graphs::find($graph_id);
			print_r($graph->function);
		}
		
	}

?>