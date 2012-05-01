<?php

/**
 * Ecriteria form base class.
 *
 * @method Ecriteria getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEcriteriaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'metric_id'       => new sfWidgetFormInputHidden(),
      'description'     => new sfWidgetFormTextarea(),
      'form_field'      => new sfWidgetFormTextarea(),
      'evaluation_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Site')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'metric_id'       => new sfValidatorPropelChoice(array('model' => 'Metric', 'column' => 'id', 'required' => false)),
      'description'     => new sfValidatorString(),
      'form_field'      => new sfValidatorString(),
      'evaluation_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Site', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ecriteria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ecriteria';
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
    $c->add(EvaluationPeer::ECRITERIA_ID, $this->object->getPrimaryKey());
    EvaluationPeer::doDelete($c, $con);

    $values = $this->getValue('evaluation_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Evaluation();
        $obj->setEcriteriaId($this->object->getPrimaryKey());
        $obj->setSiteId($value);
        $obj->save();
      }
    }
  }

}
