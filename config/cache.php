<?php defined('SYSPATH') or die('No direct script access.');
return array
(
	'file'    => array(
		'driver'             => 'file',
		'cache_dir'          => APPPATH.'cache',
		'default_expire'     => 3600,
		'ignore_on_delete'   => array(
			'.gitignore',
			'.git',
			'.svn'
		)
	),
    'redis' => array(
        'driver'             => 'redis',
        'port'               => 6379,
        'host'               => 'localhost',
        'db_num'             => 0,
        'igbinary_serialize' => false,
    ),

);
