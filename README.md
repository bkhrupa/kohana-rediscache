#rediscache-kohana3.3

Very simple cache module phpredis for kohana3.3 :) Require Kohana Cache module

Redis client - phpredis (https://github.com/nicolasff/phpredis)

Original module - (https://github.com/infarmer/phpredis-kohana3.3)

##Example

Enable module  `bootstrap.php`

    Kohana::modules(array(
        ...
        'cache' => MODPATH.'cache',
        'rediscache' => MODPATH.'rediscache',
        ...
    ));

Config, add to Kohana cache config redis driver `config/cache.php`

    ...
    'redis' => array(
        'driver'             => 'redis',
        'port'               => 6379,
        'host'               => 'localhost',
        'db_num'             => 0,
        'igbinary_serialize' => false,
    ),
    ...

If need redis to by default cache driver `bootstrap.php`

    // default cache driver
    Cache::$default = 'redis';

Usage

    $redis_cache = Cache::instance('redis');
    $redis_cache->set('test_cache', array('foo', 'bar'), 10);
    $redis_cache->get('test_cache'));


##TODO

1. Comment code
2. Kohana guide
3. Unit tests