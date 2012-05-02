<?php

/**
 * Base project form.
 * 
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
	public function setup() {
		$bootstrap_formatter = new swWidgetFormSchemaFormatterBootstrap($this->getWidgetSchema());
		$this->getWidgetSchema()->addFormFormatter('bootstrap', $bootstrap_formatter);
		$this->getWidgetSchema()->setFormFormatterName('bootstrap');
	}
}
