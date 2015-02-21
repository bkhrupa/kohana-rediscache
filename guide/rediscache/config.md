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
        'port'               => 6379,
        'host'               => 'localhost',
        'db_num'             => 0,
        'igbinary_serialize' => false,
    ),
    ...

If redis by default cache driver needed `bootstrap.php`

    // default cache driver
    Cache::$default = 'redis';
