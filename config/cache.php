<?php defined('SYSPATH') OR die('No direct script access.');

return array
(
	'file' => array(
		'driver' => 'file',
		'cache_dir' => APPPATH.'cache',
		'default_expire' => 3600,
		'ignore_on_delete' => array(
			'.gitignore',
			'.git',
			'.svn'
		)
	),
	'redis' => array(
		'driver' => 'redis',
		// Can be a host, or the path to a unix domain socket
		'host' => 'localhost',
		// Point to the port where redis is listening for connections. Set this parameter to NULL when using UNIX domain sockets. Default 6379
		'port' => NULL,
		// The connection timeout to a redis host, expressed in seconds.
		'timeout' => 1,
		'default_expire' => 3600,
		'db_num' => 0,
		'igbinary_serialize' => FALSE,
		// Custom prefix, added to all `$id` in `set`, `get`, `delete` methods
		'prefix_id' => NULL,
		'password' => NULL,
	),
);
