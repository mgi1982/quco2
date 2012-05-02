<?php
/**
 * Dynamic form to handle Metrics inputs
 */

class MetricDynamicForm extends BaseForm {
	public function configure() {
		
	}
	
	public function setMetric(Metric $metric) {
		$this->metric = $metric;
		sfContext::getInstance()->getConfiguration()->loadHelpers("I18N");
		foreach($metric->getEcriterias() as $ecriteria) {
			$dbfield = EvaluationPeer::getInstance($ecriteria);
			/* @var $ecriteria Ecriteria */
			$conf = json_decode($ecriteria->getFormField(), true);
			$field_name = $ecriteria->getName();
//			var_dump($conf, $ecriteria->getName());
			if(isset($conf['label'])) {
				$label = $conf['label'];
			} else {
				$label = null;
			}
			switch($conf['type']) {
				case 'expanded-list':
					$this->widgetSchema[$field_name] = new sfWidgetFormChoice(array(
						'expanded' => false,
						'multiple' => false,
						'choices'  => $conf['values'],
					), array(
						'class'	   => 'span12',
					));
					$this->validatorSchema[$field_name] = new sfValidatorChoice(array(
						'required' => true,
						'choices'  => array_keys($conf['values']),
					));
					break;
				case 'radio':
					$this->widgetSchema[$field_name] = new swWidgetFormSelectRadioBootstrap(array(
						'choices'  => $conf['values'],
						'class'    => 'radio',
					));
					$this->validatorSchema[$field_name] = new sfValidatorChoice(array(
						'required' => true,
						'choices'  => array_keys($conf['values']),
					));
					break;
				case 'input':
					$this->widgetSchema[$field_name] = new sfWidgetFormInput(array(
						'default'  => $conf['default'],
					), array(
						'class'	   => 'span3',
					));
					$this->validatorSchema[$field_name] = new sfValidatorInteger(array(
						'required' => true,
					), array(
						'invalid' => '"%value%"' . __(' is not an integer.'),
					));
					break;
			}
			if(null !== $dbfield->getValue()) {
				$this->widgetSchema[$field_name]->setDefault($dbfield->getValue());
			}
		}
		$this->widgetSchema->setNameFormat('metric_dynamic[%s]');	
	}
	
	public function save() {
		foreach($this->metric->getEcriterias() as $ecriteria) {
			$dbfield = EvaluationPeer::getInstance($ecriteria);
			$field_name = $ecriteria->getName();
			$dbfield->setValue($this->getValue($field_name));
			$dbfield->save();
		}
		$this->widgetSchema->setNameFormat('metric_dynamic[%s]');	
	}
}