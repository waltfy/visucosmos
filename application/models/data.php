<?php

	class Data extends Eloquent {

		public static $table = 'data';

		public function visualisation() {
			return $this->has_many('Visualisation');
		}

		static function validateType($types) {
			
			$available_graphs = array();

			$dimension = count($types);

			if ($dimension == 1) {

				if ($types[0] == 'string') {
					$graphs = Graphs::where('type', '=', 'string')->get('id');

					foreach ($graphs as $value) {
						array_push($available_graphs, $value->attributes['id']);
					}
				}

			}

			return $available_graphs;
		}
		
	}

?>