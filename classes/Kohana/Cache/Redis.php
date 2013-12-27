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
     * @var  Config
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

        parent::__construct($config);

        $this->_prepareConfig($config);

        // connect
        $this->_redis = new Redis();
        $this->_redis->connect($this->_config['host'], $this->_config['port'], 1);

        // serialize
        if($this->_config['igbinary_serialize'])
        {
            $this->_redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_IGBINARY);
        }
        else
        {
            // serialize by php
            // @url https://github.com/nicolasff/phpredis/#setoption
            $this->_redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
        }

        $this->_redis->select($this->_config['db_num']);
    }


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

    public function set($id, $data, $lifetime = false)
    {
        if($lifetime){
            return $this->_redis->setex($id, $lifetime, $data);
        } else {
            return $this->_redis->set($id, $data);
        }
    }

    public function delete($id)
    {
        return $this->_redis->del($id);
    }

    public function delete_all()
    {
        $this->_redis->flushDB();
    }

    public function __call($name, $arguments)
    {
        try {
            $rez=call_user_func_array(array($this->_redis, $name), $arguments);
        } catch (ErrorException $e){
            throw new Kohana_Cache_Exception($e->getMessage());
        }

        return $rez;
    }


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
