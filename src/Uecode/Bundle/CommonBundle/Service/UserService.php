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

use \Symfony\Component\Security\Core\SecurityContextInterface;
use \Uecode\Bundle\CommonBundle\Model\UserInterface;

/**
 * User service, for fetching user data
 */
class UserService extends Service
{

    /**
     * @var UserInterface|null
     */
    private $user = null;

    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext = null)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserService
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        if (null === $token = $this->securityContext->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }
}
