<?php defined('SYSPATH') or die('No direct script access.');

Route::set('devtools','devtools(/<action>)')
	->defaults(array(
		'controller' => 'devtools',
		'action'     => 'info'
	));
	
if (Kohana::$environment != Kohana::DEVELOPMENT)
	throw new Kohana_Exception('Devtools should not be enabled when not in development.  Check your environment variable, or disable the devtools module.');