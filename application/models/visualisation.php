<?php

	class Visualisation extends Eloquent {

		public static $table = 'visualisation';

		public function user() {
      return $this->belongs_to('User');
    }

    public static function get_json($id) {
    	return Response::download('public_html/json/'.$id.'.json');
    }

	}

?>