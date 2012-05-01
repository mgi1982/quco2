<?php

/**
 * Evaluation form base class.
 *
 * @method Evaluation getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEvaluationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'site_id'      => new sfWidgetFormInputHidden(),
      'ecriteria_id' => new sfWidgetFormInputHidden(),
      'metric_id'    => new sfWidgetFormInputHidden(),
      'value'        => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'site_id'      => new sfValidatorPropelChoice(array('model' => 'Site', 'column' => 'id', 'required' => false)),
      'ecriteria_id' => new sfValidatorPropelChoice(array('model' => 'Ecriteria', 'column' => 'id', 'required' => false)),
      'metric_id'    => new sfValidatorPropelChoice(array('model' => 'Metric', 'column' => 'id', 'required' => false)),
      'value'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
      'updated_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('evaluation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Evaluation';
  }


}
