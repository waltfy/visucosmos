<?
	
	HTML::macro('nav_link', function($url, $icon, $other_class) {
		$active = ( URI::is($url) || URI::is($url.'/*') ) ? ' selected' : '';
		return '<li class="'.$active.' '.$other_class.'"><a href="'.URL::to($url).'"><i class="icon-'.$icon.'"></i></a></li>';
	});

	$is_admin = Auth::user()->is_admin;

?>

<ul class='nav nav-stacked menu'>
	{{ HTML::nav_link('dashboard', 'home', '') }}
	{{ HTML::nav_link('visualisation', 'file', '') }}
	{{ HTML::nav_link('settings', 'cogs', '') }}
	<!-- {{ HTML::nav_link('help', 'question-sign', '') }} -->
	@if ( $is_admin == 'Y' )
		{{ HTML::nav_link('admin', 'group', '') }}
	@endif
</ul>