<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ### System requirements
 *
 * Kohana 3.3
 * PHP 5.2.4 or greater
 * driver - phpredis (https://github.com/nicolasff/phpredis)
 *
 * Original code: (https://github.com/infarmer/phpredis-kohana3.3) Mikhno Roman (admin@infarmer.ru)
 * ---------------------------------------------------------
 * @package    Kohana/Cache
 * @category   Module
 * @version    0.1
 * @author     Bogdan Khrupa (bkhrupa@gmail.com)
 * @copyright  (c) 2013 Bogdan Khrupa
 * @license    free
 */
class Kohana_Cache_Redis extends Cache {

    /**
     * Redis resource
     *
     * @var Redis
     */
    protected $_redis;

    /**
     * @var Config
     */
    protected $_config = array();

    /**
     * The default configuration for the redis server
     *
     * @var array
     */
    protected $_default_config = array(
        'host'  => 'localhost',
        'port'  => 6379,
        'db_num' => 0,
        'igbinary_serialize' => false,
    );

    /**
     * Constructs the redis Kohana_Cache object
     *
     * @param   array     configuration
     * @throws  Kohana_Cache_Exception
     */
    protected function __construct(array $config)
    {
        if (!extension_loaded('redis'))
        {
            throw new Cache_Exception('PHP redis extension is not available.');
        }

        // Setup parent
        parent::__construct($config);

        // Prepare config
        $this->_prepareConfig($config);

        // Connect
        $this->_redis = new Redis();
        $this->_redis->connect($this->_config['host'], $this->_config['port'], 1);

        // Serialize
        if($this->_config['igbinary_serialize'])
        {
            $this->_redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_IGBINARY);
        }
        else
        {
            // Serialize by php
            // @url https://github.com/nicolasff/phpredis/#setoption
            $this->_redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
        }

        // Select database
        $this->_redis->select($this->_config['db_num']);
    }

    /**
     * Get cached value by id
     *
     * @param   string  $id         id of cache to entry
     * @param   null    $default    default value to return if cache miss
     * @return  mixed
     */
    public function get($id, $default = NULL)
    {
        // Get the value from Redis
        $value = $this->_redis->get($id);

        if(empty($value))
        {
            $value = $default;
        }

        // Return the value
        return $value;
    }

    /**
     * Set a value to cache
     *
     * @param   string      $id         id of cache to entry
     * @param   mixed       $data       mixed data
     * @param   bool|int    $lifetime   Expire time in seconds
     * @return  bool        TRUE if the command is successful
     */
    public function set($id, $data, $lifetime = false)
    {
        if($lifetime)
        {
            return $this->_redis->setex($id, $lifetime, $data);
        }
        else
        {
            return $this->_redis->set($id, $data);
        }
    }

    /**
     * Delete cache by id
     *
     * @param   string    $id
     * @return  int       Number of keys deleted
     */
    public function delete($id)
    {
        return $this->_redis->del($id);
    }

    /**
     * Flush all redis cache
     *
     * @return  bool    Always TRUE
     */
    public function delete_all()
    {
        $this->_redis->flushDB();
    }

    /**
     * Call redis functions
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Kohana_Cache_Exception
     */
    public function __call($name, $arguments)
    {
        try
        {
            $rez = call_user_func_array(array($this->_redis, $name), $arguments);
        }
        catch (ErrorException $e)
        {
            throw new Kohana_Cache_Exception($e->getMessage());
        }

        return $rez;
    }


    /**
     * Prepare config
     *
     * @param $config
     */
    private function _prepareConfig($config)
    {
        foreach($this->_default_config as $key => $value)
        {
            if(isset($config[$key]))
            {
                $this->_config[$key] = $config[$key];
            }
            else
            {
                // default
                $this->_config[$key] = $value;
            }
        }
    }

}
