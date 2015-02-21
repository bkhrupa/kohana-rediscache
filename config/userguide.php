<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'modules' => array(

		// This should be the path to this modules userguide pages, without the 'guide/'. Ex: '/guide/modulename/' would be 'modulename'
		'rediscache' => array(

			// Whether this modules userguide pages should be shown
			'enabled' => TRUE,

			// The name that should show up on the userguide index page
			'name' => 'Redis cache',

			// A short description of this module, shown on the index page
			'description' => 'Redis cache guide.',

			// Copyright message, shown in the footer for this module
			'copyright' => '&copy; 2013–2015 Bogdan Khrupa',
		)
	)
);
