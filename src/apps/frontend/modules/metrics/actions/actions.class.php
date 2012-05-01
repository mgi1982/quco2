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
		$purl = parse_url($this->getUser()->getAttribute('url'));
		if($purl && !isset($purl['scheme'])) {
			if(isset($purl['host'])) {
				$url = 'http://' . $purl['host'];
			} else if(isset($purl['path'])) {
				$url = 'http://' . $purl['path'];
			} else {
				$url = 'http://' . $this->getUser()->getAttribute('url');
			}
			$this->getUser()->setAttribute('url', $url);
		}
	}

	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$current = SitePeer::getCurrent();
		if(trim($current->getDescription()) == '') {
			$this->form = new SiteForm($current);
			if($request->getMethod() == sfRequest::POST) {
				$this->form->bind(
						$request->getParameter($this->form->getName()),
						$request->getFiles($this->form->getName())
				);
				if ($this->form->isValid())
				{
					$this->form->save();
					unset($this->form);
				}
			}
		}
	}
}
