<?php

/*
|--------------------------------------------------------------------------
| Application 
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::get('/', function()
{
	return View::make('home.index');
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::post('home/signin', function () {
	$username = strtolower(Input::get('username'));
	$password = Input::get('password');

	$credentials = array('username' => $username, 'password' => $password);

	if (Auth::attempt($credentials)) {

		$remember = Input::get('remember');

		if (!empty($remember)) {
			Auth::login(Auth::user()->id, true);
		}

		return Redirect::to('dashboard');
	}

	else {
		return Redirect::to('home')->with('login_errors', true);
	}

});

Route::post('settings/add_admin', function () {

	$input = Input::all();

	$rules = array(
		'username' => 'exists:users|required|different:current_user'
	);

	$messages	= array(

		'username_required' => 'You must enter a student number to be given admin privileges.',
		'username_different' => 'You cannnot change your own admin privileges.',
		'username_exists' => 'This user does not exist, try again.'

	);

	$validation = Validator::make($input, $rules, $messages);

	if ($validation->fails())	{
	  return Redirect::to('admin/privileges')->with_errors($validation);
	}

	else {
		$user = User::where('username', '=', Input::get('username'))->first();
		$user->is_admin = 'Y';
		$user->save();

		return Redirect::to('admin/privileges')->with('add_success', true);
	}

});

Route::post('settings/rm_admin', function () {

	$input = Input::all();

	$rules = array(
		'username' => 'exists:users|required|different:current_user'
	);

	$messages	= array(

		'username_required' => 'You must enter a student number to remove admin privileges.',
		'username_different' => 'You cannnot change your own admin privileges.',
		'username_exists' => 'This user does not exist, try again.'

	);

	$validation = Validator::make($input, $rules, $messages);

	if ($validation->fails())	{
	  return Redirect::to('admin/privileges')->with_errors($validation);
	}

	else {

		$user = User::where('username', '=', Input::get('username'))->first();
		$user->is_admin = 'N';
		$user->save();

		return Redirect::to('admin/privileges')->with('remove_success', true);
	}

});

Route::post('settings/changepass', function() {

	$input = Input::all();
	$password = Input::get('password');
	$password_hashed = Hash::make($password);

	$rules = array(
		'password' => 'required'
	);

	$messages	= array(

		'password_required' => 'You must enter a password.',

	);

	$validation = Validator::make($input, $rules, $messages);

	if ($validation->fails())	{
	  return Redirect::to('settings/password')->with_errors($validation);
	}

	else {

		$user = User::find(Auth::user()->id);
		$user->password = $password_hashed;
		$user->save();

		$mail = new SMTP();
		$mail->to($user->email);
		$mail->from('admin@visucosmos.info', 'VisuCosmos');
		$mail->subject('VisuCosmos - Your password has been changed!');
		$mail->body("Hey, your new password is: '$password', please destroy this message. Let us know if this wasn't you.");
		$result = $mail->send();

		return Redirect::to('settings/password')->with('success', true);
	}

});

Route::post('admin/register', function() {

	$input = Input::all();

	function generateRandomString($length = 10) {
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $randomString;
	}

	$email = Input::get('email');
	$password = generateRandomString();

	$password_hashed = Hash::make($password);
	$std_no = Input::get('username');

	$rules = array(
		'email' => 'required|email|unique:users',
		'username' => 'required|unique:users'
	);

	$messages = array(
		'email_required' => 'Please provide an email address.',
		'email_email' => 'Please provide a valid email address.',
		'email_unique' => 'The email address you provided is already being used.',
		'username_required' => 'Please provide a student number.',
		'username_unique' => 'This student is already registered.',
	);

	$validation = Validator::make($input, $rules, $messages);

	if ($validation->fails())	{
	  return Redirect::to('admin/newuser')->with_errors($validation);
	}

	else {

		$user = new User;
		$user->email = $email;
		$user->password = $password_hashed;
		$user->username = $std_no;
		$user->save();

		$mail = new SMTP();
		$mail->to($email);
		$mail->from('admin@visucosmos.info', 'VisuCosmos');
		$mail->subject('Your VisuCosmos Account!');
		$mail->body("Hello! Welcome to VisuCosmos, your password is: '$password', please change this asap. Simply login with your email @ http://visucosmos.info");
		$result = $mail->send();

		return Redirect::to('admin/newuser')->with('success', true);
	}

});

Route::post('settings/add_data', 'admin@storedata');
Route::post('settings/mark_data', 'admin@markdata');
Route::post('settings/detect_type', 'admin@detecttype');

Route::post('settings/data_finish', function() {
	return View::make('settings.admin');
});

Route::post('visualisation/new', function() {

	$input = Input::all();

	$rules = array(
		'name' => 'required',
		'data-set' => 'required'
	);

	$messages = array(
		'name_required' => 'You must enter a visualisation name.',
		'data-set' => 'You must select a data set to be used.'
	);

	$validation = Validator::make($input, $rules, $messages);

	if ($validation->fails())	{
	  return Redirect::to('visualisation/')->with_errors($validation);
	}

	else {
		$visualisation = new Visualisation;
		$visualisation->data_set_id = Input::get('data-set');
		$visualisation->name = Input::get('name');
		$visualisation->user_id = Auth::user()->id;
		$visualisation->save();

		return Redirect::to('visualisation/edit/'.$visualisation->id)->with('data_set', Input::get('data-set'));
	}

});

Route::post('settings/getback', function() {

	$input = Input::all();

	$rules = array(
		'username' => 'required|exists:users'
	);

	$messages	= array(

		'username_required' => 'You must enter a student number to retrieve a visualisation.',
		'username_exists' => 'This user does not exist, try again.'

	);

	$validation = Validator::make($input, $rules, $messages);

	if ($validation->fails())	{
	  return Redirect::to('admin/retrieve')->with_errors($validation);
	}

	else {

		$user = User::where('username', '=', Input::get('username'))->first();

		$retrieved = DB::query("SELECT * FROM visualisation WHERE user_id = '$user->id' AND is_active = 'N'");

		if ($retrieved == null) {
			return Redirect::to('admin/retrieve')->with('no_vis', true);			
		}

		return Redirect::to('admin/retrieve')->with('retrieved', $retrieved);
	}

});

Route::post('data/generate', function(){

	$input = Input::all();

	$vis_id = Input::get('vis_id');
	$visu = Visualisation::find($vis_id);
	$data_set = $visu->data_set_id;

	$attr = Input::get('selected_attr');

	$rules = array(
		'selected_attr' => 'required'
	);

	$messages	= array(

		'selected_attr_required' => 'You must selected at least one attribute.',

	);

	$validation = Validator::make($input, $rules, $messages);

	if ($validation->fails())	{

		return Redirect::to('visualisation/edit/'.$vis_id)->with_errors($validation);

	}

	else {

		$data_types = Data::where('data_set_id', '=', $data_set)->where('line_type', '=', 'T')->first($attr);
	
		$types = array();

		foreach ($data_types->attributes as $type) {
			array_push($types, $type);
		}

		$dimension = count($data_types->attributes);

		$available_graphs = Data::validateType($types);
		$available_graphs = serialize($available_graphs);
		$graphs = unserialize($available_graphs);
		$visu->available_graphs = $available_graphs;
		$visu->dimension = $dimension;
		$visu->save();
		$attr = serialize($attr);
		$visu->params = $attr;
		$visu->save();

		$data = Data::getJson($data_set, Input::get('selected_attr'));
		
		File::put("public_html/json/$vis_id.json", $data);

		$visu->json_path = "json/$vis_id.json";
		$visu->save();

		if ($graphs != null) {
			return Redirect::to('visualisation/edit/'.$vis_id)->with('response', $visu->json_path)->with('saved_attr', $attr);
		}

		else {
			return Redirect::to('visualisation/edit/'.$vis_id)->with('response', $visu->json_path)->with('saved_attr', $attr)->with('no_graphs', true);
		}

	}

});

Route::controller(Controller::detect());

Route::filter('before', function() {
	// Do stuff before every request to your application...
});

Route::filter('after', function($response) {
	// Do stuff after every request to your application...
});

Route::filter('csrf', function() {
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function() {
	if (Auth::guest()) return Redirect::to('home');
});

Route::filter('owner', function($id) {
	echo "called";
	$visualisations = User::find(Auth::user()->id)->visualisation()->get('id');
	echo "test".$id;
	// $owns = array();

	// foreach ($visualisations as $visu) {
	// 	array_push($owns, $visu->attributes['id']);
	// }

	// if (!in_array($id, $owns)) {
	// 	return Redirect::to('dashboard');
	// }
		
});

Route::filter('admin_auth', function() {
	if (Auth::user()->is_admin == 'N') return Redirect::to('dashboard')->with('not_admin', true);
});