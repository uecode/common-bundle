<?php
/**
 * @package common-bundle
 * @author Aaron Scherer
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



use \Symfony\Component\HttpFoundation\Response;

use \Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{
	/**
	 * @var Response
	 */
	private $response;

	/**
	 * @param Response $response
	 */
	public function __construct( Response $response)
	{
		$this->response = $response;
	}

	/**
	 * @return Response
	 */
	public function getResponse( )
	{
		return $this->response;
	}

	/**
	 * @param  Response $response
	 * @return ResponseEvent
	 */
	public function setResponse( Response $response )
	{
		$this->response = $response;

		return $this;
	}
}
