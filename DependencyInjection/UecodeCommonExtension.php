<?php
/**
 * @author Aaron Scherer
 * @date 10/8/12
 */
namespace Uecode\CommonBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Uecode Common Extension
 */
class UecodeCommonExtension extends Extension
{
	/**
	 * {@inheritdoc}
	 */
	public function load( array $configs, ContainerBuilder $container )
	{
		$configuration = new Configuration( $container->getParameter( 'kernel.debug' ) );
		$config = $this->processConfiguration( $configuration, $configs );
		$loader = new Loader\YamlFileLoader( $container, new FileLocator( __DIR__ . '/../Resources/config' ) );
		$loader->load( 'services.yml' );

		$this->setParameters( $container, $config );

	}

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
	    return new Configuration( $container->getParameter( 'kernel.debug' ) );
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
