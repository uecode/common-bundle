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
namespace Uecode\Bundle\CommonBUndle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;


use \Uecode\Bundle\UecodeBundle\DependencyInjection\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function appendTo( ArrayNodeDefinition &$rootNode )
	{
		$rootNode->append( $this->addCommonNode() );
	}

	/**
	 *
	 */
	private function addCommonNode()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode    = $treeBuilder->root( 'common' );

		$rootNode->append( $this->addServiceNode() );

		return $rootNode;
	}

	/**
	 *
	 */
	private function addServiceNode()
	{
		$treeBuilder = new TreeBuilder();
		$node = $treeBuilder->root( 'services' );
		
		$node
			->addDefaultsIfNotSet()
			->info( "Settings for the services in this bundle" )
			->children()
				->arrayNode( 'user' )
					->addDefaultsIfNotSet()
					->children()
						->scalarNode( 'entity' )
							->isRequired()
							->cannotBeEmpty()
						->end()
						->scalarNode( 'id_property' )
							->isRequired()
							->defaultValue( 'id' )
							->cannotBeEmpty()
						->end()
					->end()
				->end()
			->end()
		;

		return $node;
							
	}
}
