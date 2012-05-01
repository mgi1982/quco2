<?php

/**
 * Metric form base class.
 *
 * @method Metric getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMetricForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'description'     => new sfWidgetFormTextarea(),
      'evaluation_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Site')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'description'     => new sfValidatorString(),
      'evaluation_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Site', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('metric[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Metric';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['evaluation_list']))
    {
      $values = array();
      foreach ($this->object->getEvaluations() as $obj)
      {
        $values[] = $obj->getSiteId();
      }

      $this->setDefault('evaluation_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveEvaluationList($con);
  }

  public function saveEvaluationList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['evaluation_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EvaluationPeer::METRIC_ID, $this->object->getPrimaryKey());
    EvaluationPeer::doDelete($c, $con);

    $values = $this->getValue('evaluation_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Evaluation();
        $obj->setMetricId($this->object->getPrimaryKey());
        $obj->setSiteId($value);
        $obj->save();
      }
    }
  }

}
