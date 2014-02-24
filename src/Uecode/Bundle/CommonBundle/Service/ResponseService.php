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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\DelegatingEngine;
use Symfony\Bundle\FrameworkBundle\Kernel;
use Uecode\Bundle\CommonBundle\UecodeCommonEvents;
use Uecode\Bundle\CommonBundle\Event\ResponseEvent;
use Uecode\Bundle\CommonBundle\Traits\DispatcherAwareTrait;

class ResponseService extends Service
{
    use DispatcherAwareTrait;

    /**
     * @var DelegatingEngine
     */
    private $templating;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var ViewService
     */
    private $view;

    public function buildResponse($content = null)
    {
        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }

    public function returnErrors($errors)
    {
        $response = $this->buildResponse(json_encode(['errors' => $errors]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function returnJavascript($javascript)
    {
        $response = $this->buildResponse(json_encode(['javascript' => $javascript]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function returnMixed(array $mixed)
    {

        $response = $this->buildResponse(json_encode($mixed));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function renderTemplate($view = '', array $parameters = [], Response $response = null)
    {
        $viewService = $this->getView();
        $reserved    = array('view', 'env', 'app');

        foreach ($reserved as $res) {
            if (isset($parameters[$res])) {
                throw new \Exception("`{$res}` is a reserved variable. Please create a new variable.");
            }
        }

        foreach ($viewService->all() as $k => $v) {
            foreach ($reserved as $res) {
                if ($k === $res) {
                    throw new \Exception("`{$res}` is a reserved variable. Please create a new variable.");
                }
            }

            $parameters[$k] = $v;
        }

        $parse = $this->parseView($view);
        $view  = $parse['bundle'] . ':' . $parse['controller'] . ':' . $parse['action'] . '.' . $parse['ext'];

        $response =
            $this->getTemplating()
                ->renderResponse(
                    $view,
                    array_merge(['vars' => $this->view], $parameters),
                    $response
                );
        $response->headers->set('Content-Type', 'text/html');

        $this->dispatcher->dispatch(UecodeCommonEvents::RENDER_TEMPLATE_RESPONSE, new ResponseEvent($response));

        return $response;
    }

    public function render($view, array $parameters = [], Response $response = null)
    {
        return $this->renderTemplate($view, $parameters, $response);
    }

    /**
     * Forwards the request to another controller.
     *
     * @param string $view  The controller name (a string like BlogBundle:Post:index)
     * @param array  $path  An array of path parameters
     * @param array  $query An array of query parameters
     *
     * @return Response A Response instance
     */
    public function forward($view, array $path = array(), array $query = array())
    {
        $controller = implode(':', $this->parseView($view, false));

        return $this->getKernel()
            ->forward($controller, $path, $query);
    }

    public function parseView($view = '', $returnView = true)
    {
        if (strpos($view, '::') === false) {
            if (substr_count($view, ':') < 2) {
                $trace = debug_backtrace();

                $i = 1;
                while (strpos($trace[$i]['function'], 'Action') === false) {
                    $i++;
                }

                $caller     = explode('\\', $trace[$i]['class']);
                $action     = str_replace('Action', '', $trace[$i]['function']);
                $bundle     = $caller[0] . $caller[1];
                $controller = str_replace('Controller', '', $caller[3]);
                switch (substr_count($view, ':')) {
                    case 1:
                        $view = $bundle . ':' . $view;
                        break;
                    case 0:
                        if (empty($view)) {
                            $view = $action;
                        }
                        $view = $bundle . ':' . $controller . ':' . $view;
                        break;
                }
            }

            $temp       = explode(':', $view);
            $bundle     = $temp[0];
            $controller = $temp [1];
            $temp2      = explode('.', $temp[2], 2);
            $action     = $temp2[0];
            $ext        = empty($temp2[1]) ? 'html.php' : $temp2[1];
        }

        $result = [
            'bundle'     => $bundle,
            'controller' => $controller,
            'action'     => $action,
            'ext'        => $ext
        ];
        if ($returnView) {
            $result['view'] = $view;
        }

        return $result;
    }

    /**
     * @param \Symfony\Bundle\FrameworkBundle\Templating\DelegatingEngine $templating
     */
    public function setTemplating($templating)
    {
        $this->templating = $templating;
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Templating\DelegatingEngine
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    /**
     * @param \Uecode\Bundle\CommonBundle\Service\ViewService $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * @return \Uecode\Bundle\CommonBundle\Service\ViewService
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param \Symfony\Bundle\FrameworkBundle\Kernel $kernel
     */
    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Kernel
     */
    public function getKernel()
    {
        return $this->kernel;
    }
}
