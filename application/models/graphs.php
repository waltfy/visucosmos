<?php

	class Graphs extends Eloquent {

		public static $table = 'graphs';

		public function visualisation() {
			return $this->has_many('Visualisation');
		}

		public static function getFunctionName($graph_id) {
			$graph = Graphs::find($graph_id);
			
			if (isset($graph->function)) {
				return $graph->function;	
			} else {
				return null;
			}
		}
	}

?>