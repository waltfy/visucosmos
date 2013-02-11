<?php

	class User extends Eloquent {

		public static $table = 'users';

		public function visualisation() {
			return $this->has_many('Visualisation');
		}
		
	}

?>