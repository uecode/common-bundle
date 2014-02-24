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

namespace Uecode\Bundle\CommonBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Uecode\Bundle\CommonBundle\UecodeCommonEvents;
use Uecode\Bundle\CommonBundle\Event\ControllerEvent;
use Uecode\Bundle\CommonBundle\Model\InitializableControllerInterface;
use Uecode\Bundle\CommonBundle\Traits\DatabaseAwareTrait;
use Uecode\Bundle\CommonBundle\Traits\UserServiceAwareTrait;
use Uecode\Bundle\CommonBundle\Traits\ResponseServiceAwareTrait;
use Uecode\Bundle\CommonBundle\Traits\ViewServiceAwareTrait;
use Uecode\Bundle\CommonBundle\Traits\DispatcherAwareTrait;

class ControllerListener
{
    use DatabaseAwareTrait, UserServiceAwareTrait, ResponseServiceAwareTrait, ViewServiceAwareTrait,
        DispatcherAwareTrait;

    /**
     * Checks to see if the controller is an InitializableControllerInterface.
     * If it is, it initializes it with some of the services
     *
     * @param FilterControllerEvent $event
     *
     * @return void
     */
    public function preController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        // Return if its not an array
        if (!is_array($controller)) {
            return;
        }

        $controllerObject = $controller[0];

        // Make sure it can initialize
        if ($controllerObject instanceof InitializableControllerInterface) {

            $this->dispatcher->dispatch(
                UecodeCommonEvents::PRE_CONTROLLER_INITIALIZE,
                new ControllerEvent($controllerObject, $event)
            );

            $controllerObject->initialize(
                $this->getEntityManager(),
                $this->getUserService(),
                $this->getResponseService(),
                $this->getViewService()
            );

            $this->dispatcher->dispatch(
                UecodeCommonEvents::POST_CONTROLLER_INITIALIZE,
                new ControllerEvent($controllerObject, $event)
            );
        }

        return;
    }
}
