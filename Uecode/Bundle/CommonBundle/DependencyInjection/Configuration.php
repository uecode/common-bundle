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
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root( 'uecode_common' );

		$rootNode
			->children()
				->append( $this->getServiceNode() )
			->end();
		;

		return $treeBuilder;
	}

	/**
	 *
	 */
	private function getServiceNode()
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
							->validate()
							->ifTrue( function( $v ) { return !is_string( $v ) || !class_exists( $v ); } )
								->thenInvalid( "Expected a valid class name for entity" )
							->end()
						->end()
						->scalarNode( 'id_property' )
							->isRequired()
							->defaultValue( 'id' )
							->validate()
							->ifTrue( function( $v ) { return !is_string( $v ); } )
								->thenInvalid( "Expected a valid property for ID" )
							->end()
						->end()
					->end()
				->end()
			->end()
		;

		return $node;
							
	}
}
