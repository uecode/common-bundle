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
namespace Uecode\Bundle\CommonBundle\Service;

use \Symfony\Component\Security\Core\SecurityContext;

use \Uecode\Bundle\CommonBundle\Model\UserInterface;
use \Uecode\Bundle\CommonBundle\Traits\DatabaseAwareTrait;

/**
 * User service, for fetching user data
 */
class UserService extends Service
{

	use DatabaseAwareTrait;

	/**
	 * @var UserInterface|null
	 */
	private $user = null;

	/**
	 * @var SecurityContext
	 */
	private $securityContext;
	
	/**
	 * @var string
	 */
	private $userEntity;

	/**
	 * @var string
	 */
	private $idProperty;

	/**
	 * @param string $userEntity
	 * @param string $idProperty
	 */
	public function __construct( $userEntity, $idProperty )
	{
		$this->userEntity = $userEntity;
		$this->idProperty = $idProperty;
	}

	/**
	 * @param UserInterface $user
	 *
	 * @return UserService
	 */
	public function setUser( UserInterface $user )
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		if ( is_null( $this->user ) ) {
			$token = $this->getSecurityContext()->getToken();

			if ( $token === null ) {
				$user = 'anon.';
			} else {
				$user = $token->getUser();
			}

			if ( !is_string( $user ) ) {
				if( !( $user instanceof UserInterface ) ) {
					throw new \Exception( sprintf(
						"Expected user to be of type %s",
						"\Uecode\Bundle\CommonBundle\Model\UserInterface"
					) );
				}

				$this->user = $this->fetchUser( $user->getUserId() );
			} else {
				$this->user = $user;
			}
		}

		return $this->user;
	}

	/**
	 * @param \Symfony\Component\Security\Core\SecurityContext $securityContext
	 *
	 * @return UserService
	 */
	public function setSecurityContext( SecurityContext $securityContext )
	{
		$this->securityContext = $securityContext;

		return $this;
	}

	/**
	 * @return \Symfony\Component\Security\Core\SecurityContext
	 */
	public function getSecurityContext()
	{
		return $this->securityContext;
	}

	public function fetchUser( $userId )
	{
		$repo = $this->getEntityManager()->getRepository( $this->userEntity );

		/** @var $user User */
		$user = $repo->findOneBy( [ $this->idProperty => $userId ] );

		return $user;
	}
}
