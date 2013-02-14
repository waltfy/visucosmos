<?php

	class Visualisation extends Eloquent {

		public static $table = 'visualisation';

		public function user() {
      return $this->belongs_to('User');
    }

	}

?>