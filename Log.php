<?php
namespace Uecode\CommonBundle;

// Monolog
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;


class Log extends Logger
{
	/**
	 * Filename for Log
	 * @var string
	 */
	private $_file;

	public function __construct( $name, $file )
	{
		$this->_file = $file;
		parent::__construct( $name );
		$this->pushHandler( new StreamHandler( $this->_file, Logger::DEBUG ) );
	}

	public function getFile()
	{
		return $this->_file;
	}
}
