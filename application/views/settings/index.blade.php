@layout('layouts.member')
<? $pagetitle = 'Settings'; ?>

@section('content')
	<h2>Settings</h2>
	<small>Make changes to your personal account.</small>
	<br>
	{{ HTML::link('settings/password', 'Change Password'); }}
@endsection