<?php

/**
 * Test case for Kohana Redis Cache
 */
class Rediscache_CacheTest extends PHPUnit_Framework_TestCase
{
	public $cache;

	public function setUp()
	{
		parent::setUp();

		if ( ! extension_loaded('redis'))
		{
			$this->markTestSkipped('Redis PHP Extension is not available');
		}
		if ( ! $config = Kohana::$config->load('cache.redis'))
		{
			$this->markTestSkipped('Unable to load Redis configuration');
		}

		$redis = new Redis;
		if ( ! $redis->connect($config['host'], $config['port'], $config['timeout']))
		{
			$this->markTestSkipped('Unable to connect to redis server @ '.$config['host'].':'.$config['port']);
		}

		if ( ! array_key_exists('redis_version', $redis->info()))
		{
			$this->markTestSkipped('Redis server @ '.$config['host'].':'.$config['port'].' not responding!');
		}

		unset($redis);

		$this->cache = Cache::instance('redis');
	}

	public function test_set()
	{
		$data = array('foo', 'bar');

		$this->cache->set('test_cache', $data);
		$this->assertEquals($data, $this->cache->get('test_cache'));
		$this->assertEquals(1, $this->cache->delete('test_cache'));

	}

	public function test_set_by_time()
	{
		$data = array('foo', 'bar');

		$this->cache->set('test_cache', $data, 1);
		$this->assertEquals($data, $this->cache->get('test_cache'));
		usleep(1500000);
		$this->assertEquals(null, $this->cache->get('test_cache'));
	}

	public function test_get_by_default_value()
	{
		$this->assertEquals('foo', $this->cache->get('invalid_key', 'foo'));
	}

}
