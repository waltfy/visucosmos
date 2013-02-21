@layout('layouts.member')
<? $pagetitle = 'Settings'; ?>

@section('content')
	<h2>Administrator Settings</h2>
	<small>Perform admin tasks. These changes will affect the system directly.</small>
	<br>
	{{ HTML::link('admin/newuser', 'Add User'); }}
	<br>
	{{ HTML::link('admin/privileges', 'Add Admin Privileges'); }}
	<br>
	{{ HTML::link('admin/upload', 'New Data Set'); }}
	<br>
	{{ HTML::link('admin/retrieve', 'Retrieve Visualisations'); }}
@endsection