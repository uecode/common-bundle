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

namespace Uecode\Bundle\CommonBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Uecode\Bundle\CommonBundle\Model\InitializableControllerInterface as Controller;

class ControllerEvent extends Event
{
    /**
     * @var Controller
     */
    private $controller;

    /**
     * @var FilterControllerEvent
     */
    private $event;

    /**
     * @param Controller            $controller
     * @param FilterControllerEvent $event
     */
    public function __construct(Controller $controller, FilterControllerEvent $event)
    {
        $this->controller = $controller;
        $this->event      = $event;
    }

    /**
     * @return Controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param  Controller $controller
     *
     * @return ControllerEvent
     */
    public function setController(Controller $controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @return FilterControllerEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param  FilterControllerEvent $event
     *
     * @return ControllerEvent
     */
    public function setEvent(FilterControllerEvent $event)
    {
        $this->event = $event;

        return $this;
    }
}
