<?php

	class Graphs extends Eloquent {

		public static $table = 'graphs';

		public function visualisation() {
			return $this->has_many('Visualisation');
		}
		
	}

?>