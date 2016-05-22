<?php
/**
 * This file is part of the GLIZY framework.
 * Copyright (c) 2005-2012 Daniele Ugoletti <daniele.ugoletti@glizy.com>
 *
 * For the full copyright and license information, please view the COPYRIGHT.txt
 * file that was distributed with this source code.
 */



class org_glizy_cache_CacheFunction extends GlizyObject
{
    private $_cacheObj;
    private $parent;
    private $memoryCache;
    private $group;
    private static $memArray = array();


    function __construct($parent, $lifeTime=null, $memoryCache=false, $cacheFolder=null, $group=null)
    {
        $cacheFolder = $cacheFolder ? $cacheFolder : org_glizy_Paths::getRealPath('CACHE_CODE');
        $this->parent = $parent;
        $this->memoryCache = $memoryCache;
        $this->group = $group ? $group : $cacheFolder.get_class($this->parent);
        $options = array(
            'cacheDir' => $cacheFolder,
            'lifeTime' => !$lifeTime ? org_glizy_Config::get('CACHE_CODE') : $lifeTime,
            'readControlType' => '',
            'fileExtension' => '.php'
        );

        if ($options['lifeTime']=='-1') {
            $options['lifeTime'] = null;
        }

        $this->_cacheObj = &org_glizy_ObjectFactory::createObject('org.glizy.cache.CacheFile', $options);
    }

    /**
     * @param string   $method
     * @param array    $args
     * @param Callable $lambda
     * @return bool|mixed|string
     */
    public function get($method, $args, $lambda)
    {
        $fileName = $method . serialize($args);
        $memId = $fileName . $this->group;

        // 1. Search data in memory cache
        $data = $this->getMemoryCache($memId);
        if ($data !== false) {
            return $data;
        }

        // 2. Search data in file cache, then put it in memory cache
        $data = $this->_cacheObj->get($fileName, $this->group);
        if ($data !== false) {
            $data = $this->unserialize($data);
            $this->setMemoryCache($memId, $data);
            return $data;
        }

        // 3. Generate data and keep it in memory and in file

        /** Attention! Lambda function can return empty data
         * @see \org_glizy_dataAccessDoctrine_SchemaManager::getFields
         * Do not keep empty values in cache
         */
        $data = $lambda();

        if (!empty($data)) {
            $this->_cacheObj->save($this->serialize($data), $fileName, $this->group);
            $this->setMemoryCache($memId, $data);
        }

        return $data;
    }

    public function invalidateGroup()
    {
        $this->_cacheObj->clean($this->group);
    }

    public function remove($method, $args)
    {
        $fileName = $method.serialize($args);
        $this->_cacheObj->remove($fileName, $this->group);
    }

    private function getMemoryCache($id)
    {
        if ($this->memoryCache && isset(self::$memArray[$id])) {
            return self::$memArray[$id];
        }
        return false;
    }

    private function setMemoryCache($id, $data)
    {
        if ($this->memoryCache) {
            self::$memArray[$id] = $data;
        }
    }

    private function serialize($data)
    {
        return is_string($data) ? 'N|'.$data : 'Y|'.serialize($data);
    }

    private function unserialize($data)
    {
        return substr($data, 0, 2) == 'N|' ? substr($data, 2) : unserialize(substr($data, 2));
    }
}
