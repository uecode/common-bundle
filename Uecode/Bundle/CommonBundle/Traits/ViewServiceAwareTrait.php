<?php
/**
 * @author Aaron Scherer
 * @date 11/7/12
 */
namespace Uecode\Bundle\CommonBundle\Traits;

use \Uecode\Bundle\CommonBundle\Service\ViewService;

trait ViewServiceAwareTrait
{

	/**
	 * @var ViewService
	 */
	protected $viewService;

	/**
	 * @param \Uecode\Bundle\CommonBundle\Service\ViewService $view
	 *
	 * @return ViewAwareTrait
	 */
	public function setViewService( $viewService )
	{
		$this->viewService = $viewService;

		return $this;
	}

	/**
	 * @return \Uecode\Bundle\CommonBundle\Service\ViewService
	 */
	public function getViewService()
	{
		return $this->viewService;
	}

	public function getView()
	{
		return $this->viewService;
	}
}
