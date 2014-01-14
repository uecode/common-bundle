<?php
/**
 * @package       common-bundle
 * @author        Aaron Scherer
 * @copyright (c) 2013 Underground Elephant
 *
 * Copyright 2013 Underground Elephant
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Uecode\Bundle\CommonBundle\Service;

use Symfony\Component\Config\Definition\Exception\DuplicateKeyException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * View Service, Passes data to the render
 */
class ViewService extends Service
{

    const GET_DEFAULT = 'DEFAULTGETFORVIEW';

    /**
     * @var array
     */
    private $_data = array();

    /**
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * @param array $array
     * @param bool  $truncate
     *
     * @return array
     */
    public function setItems(array $array = array(), $truncate = false)
    {
        if ($truncate) {
            return $this->_data = $array;
        }

        foreach ($array as $k => $v) {
            $this->set($k, $v);
        }
    }

    public function getItems()
    {
        return $this->all();
    }

    public function get($key, $default = self::GET_DEFAULT)
    {
        if (array_key_exists($key, $this->_data)) {
            return $this->_data[$key];
        } else {
            if ($default != self::GET_DEFAULT) {
                return $default;
            } else {
                throw new \Exception(sprintf("The key `%s` does not exist in the view. ", $key));
            }
        }
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->_data;
    }

    public function add($key, $value)
    {
        if (array_key_exists($key, $this->_data)) {
            throw new \Exception(sprintf("The key `%s` is already in the view. ", $key));
        }
        $this->_data[$key] = $value;

        return $this;
    }

    public function replace($key, $value)
    {
        return $this->remove($key)
            ->add($key, $value);
    }

    public function set($key, $value)
    {
        if (!array_key_exists($key, $this->_data)) {
            return $this->add($key, $value);
        }

        return $this->replace($key, $value);
    }

    public function remove($key)
    {
        unset($this->_data[$key]);
        return $this;
    }
}
