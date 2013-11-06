<?php
/**
 * @package common-bundle
 * @copyright (c) 2013 Underground Elephant
 * @author Aaron Scherer
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
namespace Uecode\Bundle\CommonBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as FrameworkController;
use Symfony\Component\HttpFoundation\Response;
use Uecode\Bundle\CommonBundle\Model\InitializableControllerInterface;
use Uecode\Bundle\CommonBundle\Service\ResponseService;
use Uecode\Bundle\CommonBundle\Service\UserService;
use Uecode\Bundle\CommonBundle\Service\ViewService;
use Uecode\Bundle\CommonBundle\Traits\DatabaseAwareTrait;
use Uecode\Bundle\CommonBundle\Traits\ResponseServiceAwareTrait;
use Uecode\Bundle\CommonBundle\Traits\UserServiceAwareTrait;
use Uecode\Bundle\CommonBundle\Traits\ViewServiceAwareTrait;

/**
 * Extends BaseController, the base class is the base class for all the controllers.
 *
 * Base Class for All Controllers.
 */
abstract class Controller extends FrameworkController implements InitializableControllerInterface
{
	use DatabaseAwareTrait,
	    UserServiceAwareTrait,
	    ResponseServiceAwareTrait,
	    ViewServiceAwareTrait;

	/**
	 * Initialization function.
	 *
	 * Called at the beginning of every controller. Used for simplifying controllers
	 */
	public function initialize( EntityManager $em, UserService $us, ResponseService $rs, ViewService $vws )
	{
		$this->setEntityManager( $em );
		$this->setUserService( $us );
		$this->setResponseService( $rs );
		$this->setViewService( $vws );
	}

	/**
	 * Overwrites the render function 
	 * 
	 * @return Response
	 */
	public function render( $view, array $parameters = array(), Response $response = null )
	{
		return $this->getResponseService()->render( $view, $parameters, $response );
	}

	/**
	 * Slugify's the given string
	 *
	 * @return string
	 */
	protected function slug( $string )
	{
		$str = strtolower( trim( $string ) );
		$str = preg_replace( '/[^a-z0-9-]/', '-', $str );

		return preg_replace( '/-+/', "-", $str );
	}
}
