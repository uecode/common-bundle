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
namespace Uecode\Bundle\CommonBundle\Traits;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

trait DatabaseAwareTrait
{

    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry Doctrine Registry
     */
    protected $registry;

    /**
     * @var \Doctrine\ORM\EntityManager Doctrine Entity Manager
     */
    protected $em;

    /**
     * @var \Doctrine\DBAL\Connection Doctrine Connection
     */
    protected $dbal;

    public function setConnection(Connection $dbal)
    {
        $this->setDbal($dbal);
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getDbal()
    {
        return $this->dbal;
    }

    /**
     * @param \Doctrine\DBAL\Connection $dbal
     */
    public function setDbal(Connection $dbal)
    {
        $this->dbal = $dbal;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->dbal;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->setEm($em);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @param \Doctrine\Bundle\DoctrineBundle\Registry $registry
     */
    public function setRegistry(Registry $registry)
    {
        $this->registry = $registry;
    }
}
