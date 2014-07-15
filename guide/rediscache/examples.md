# Examples

Usage

    $redis_cache = Cache::instance('redis');
    $redis_cache->set('test_cache', array('foo', 'bar'), 10);
    $redis_cache->get('test_cache');
