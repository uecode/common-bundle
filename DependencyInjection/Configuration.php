<?php
namespace Uecode\CommonBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Aaron Scherer
 * @date 10/8/12
 */

/**
 * Configuration for the Common Bundle
 */
class Configuration implements ConfigurationInterface
{
	private $debug;

	/**
	 * Constructor
	 *
	 * @param Boolean $debug Whether to use the debug mode
	 */
	public function  __construct( $debug )
	{
		$this->debug = (Boolean)$debug;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode    = $treeBuilder->root( 'uecode_common' );

		$rootNode
			->children()
			->append( $this->addGearmanNode() )
			->append( $this->addDaemonNode() )
			->end();

		return $treeBuilder;
	}

	/**
	 * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
	 */
	public function addGearmanNode()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode    = $treeBuilder->root( 'gearman' );

		$rootNode
			->children()
				->scalarNode( 'timeout' )->defaultValue( 10 )->end()
				->arrayNode( 'connections' )
					->requiresAtLeastOneElement()
					->useAttributeAsKey( 'name' )
					->prototype( 'array' )
						->children()
							->scalarNode( 'host' )
								->defaultValue( '127.0.0.1' )
							->end()
							->scalarNode( 'port' )
								->defaultValue( '4730' )
							->end()
						->end()
					->end()
				->end()
				->scalarNode( 'debug' )
					->defaultValue( 'false' )
				->end()
			->end()
		;
		return $rootNode;
	}

	/**
	 * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
	 */
	public function addDaemonNode()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode    = $treeBuilder->root( 'daemon' );

		$rootNode
			->children()
				->arrayNode( 'daemons' )
					->requiresAtLeastOneElement()
					->useAttributeAsKey( 'name' )
					->prototype( 'array' )
						->children()
							->scalarNode( 'appName' )->defaultValue( 'systemDaemon' )->end()
							->scalarNode( 'appDir' )->defaultValue( '%kernel.root_dir%' )->end()
							->scalarNode( 'appDescription' )->defaultValue( 'System Daemon' )->end()
							->scalarNode( 'logDir' )->defaultValue( '%kernel.logs_dir%' )->end()
							->scalarNode( 'authorName' )->defaultValue( '' )->end()
							->scalarNode( 'authorEmail' )->defaultValue( '' )->end()
							->scalarNode( 'appPidLocation' )->defaultValue( '%kernel.cache_dir%/daemons/' )->end()
							->scalarNode( 'sysMaxExecutionTime' )->defaultValue( '0' )->end()
							->scalarNode( 'sysMaxInputTime' )->defaultValue( '0' )->end()
							->scalarNode( 'sysMemoryLimit' )->defaultValue( '1024M' )->end()
							->scalarNode( 'appUser' )->defaultValue( 'www-data' )->end()
							->scalarNode( 'appGroup' )->defaultValue( 'www-data' )->end()
							->scalarNode( 'appRunAsGID' )->defaultValue( '1000' )->end()
							->scalarNode( 'appRunAsUID' )->defaultValue( '1000' )->end()
						->end()
					->end()
				->end()
			->scalarNode( 'debug' )->defaultValue( 'false' )->end()
			->end()
		;

		return $rootNode;
	}

}
