<?php

/**
 * Site form base class.
 *
 * @method Site getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSiteForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'url'             => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextarea(),
      'evaluation_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Ecriteria')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'url'             => new sfValidatorString(array('max_length' => 255)),
      'description'     => new sfValidatorString(),
      'evaluation_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Ecriteria', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Site', 'column' => array('url')))
    );

    $this->widgetSchema->setNameFormat('site[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Site';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['evaluation_list']))
    {
      $values = array();
      foreach ($this->object->getEvaluations() as $obj)
      {
        $values[] = $obj->getEcriteriaId();
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
    $c->add(EvaluationPeer::SITE_ID, $this->object->getPrimaryKey());
    EvaluationPeer::doDelete($c, $con);

    $values = $this->getValue('evaluation_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Evaluation();
        $obj->setSiteId($this->object->getPrimaryKey());
        $obj->setEcriteriaId($value);
        $obj->save();
      }
    }
  }

}
