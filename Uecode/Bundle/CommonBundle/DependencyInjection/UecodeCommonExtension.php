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

namespace Uecode\Bundle\CommonBundle\DependencyInjection;

use \Symfony\Component\DependencyInjection\ContainerBuilder;
use \Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use \Symfony\Component\Config\FileLocator;
use \Symfony\Component\DependencyInjection\Loader;
use \Symfony\Component\HttpKernel\DependencyInjection\Extension;

class UecodeCommonExtension extends Extension
{
	/**
	 * {@inheritdoc}
	 */
	public function load( array $configs, ContainerBuilder $container )
	{
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);

		$dir    = __DIR__ . '/../Resources/config/services/';
		$loader = new Loader\YamlFileLoader( $container, new FileLocator( $dir ) );
		foreach ( glob( $dir . '*.yml' ) as $file ) {
			$loader->load( $file );
		}
		
		$this->setParameters( $container, $config );
	}

	private function setParameters( ContainerBuilder $container, array $configs, $prefix = 'uecode' )
	{
		foreach( $configs as $key => $value )
		{
			if( is_array( $value ) )
			{
				$this->setParameters( $container, $configs[ $key ], ltrim( $prefix . '.' . $key, '.' ) );
				$container->setParameter(  ltrim( $prefix . '.' . $key, '.' ), $value );
			}
			else
			{
				$container->setParameter( ltrim( $prefix . '.' . $key, '.' ), $value );
			}
		}
	}
}
