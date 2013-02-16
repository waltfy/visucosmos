<?php

	class Data extends Eloquent {

		public static $table = 'data';

		public function visualisation() {
			return $this->has_many('Visualisation');
		}
		
	}

?>