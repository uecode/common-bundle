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
namespace Uecode\Bundle\CommonBundle\Model;

use \Doctrine\ORM\EntityManager;
use \Uecode\Bundle\CommonBundle\Service\UserService;
use \Uecode\Bundle\CommonBundle\Service\ResponseService;
use \Uecode\Bundle\CommonBundle\Service\ViewService;

/**
 * InitializableControllerInterface Class
 */
interface InitializableControllerInterface
{

	public function initialize(
		EntityManager $em,
		UserService $us,
		ResponseService $rs,
		ViewService $vws
	);
}

