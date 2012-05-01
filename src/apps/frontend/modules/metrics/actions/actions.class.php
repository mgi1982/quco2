<?php

/**
 * metrics actions.
 *
 * @package    sf_sandbox
 * @subpackage metrics
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class metricsActions extends sfActions
{
	public function preExecute() {
		$request = $this->getRequest();
		$url = sfConfig::get('app_default_url');
		if($request->hasParameter('url')) {
			$this->getUser()->setAttribute('url', $request->getParameter('url'));
		} elseif(!$this->getUser()->hasAttribute('url')) {
			$this->getUser()->setAttribute('url', sfConfig::get('app_default_url'));
		} 
	}

	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
	}
}
