# Configuration

Enable module `bootstrap.php`

    Kohana::modules(array(
        ...
        'cache' => MODPATH.'cache',
        'rediscache' => MODPATH.'rediscache',
        ...
    ));

Config. Add to Kohana cache config redis driver `config/cache.php`

    ...
    'redis' => array(
        'driver'             => 'redis',
        'host'               => 'localhost',
        'port'               => 6379,
        'timeout'            => 1
        'db_num'             => 0,
        'igbinary_serialize' => FALSE,
    ),
    ...

If redis by default cache driver needed `bootstrap.php`

    // default cache driver
    Cache::$default = 'redis';

## Using unix socket connection

    'redis' => array(
        'driver'             => 'redis',
        'host'               => '/var/run/redis/redis.sock',
        // Set this parameter to NULL when using UNIX domain sockets.
        'port'               => NULL
        'timeout'            => 1
        'db_num'             => 0,
        'igbinary_serialize' => FALSE,
    ),

## Add custom id prefix

If you need add custom prefix to redis key `id` to `set()`, `get()` and `delete()` methods.

    'redis' => array(
        'driver'             => 'redis',
        'host'               => 'localhost',
        'port'               => 6379,
        'timeout'            => 1
        'db_num'             => 0,
        'igbinary_serialize' => FALSE,
        'prefix_id' => 'prefix_',
    ),
    