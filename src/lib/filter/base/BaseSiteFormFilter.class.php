<?php

/**
 * Site filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSiteFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'evaluation_list' => new sfWidgetFormPropelChoice(array('model' => 'Ecriteria', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'url'             => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'evaluation_list' => new sfValidatorPropelChoice(array('model' => 'Ecriteria', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('site_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addEvaluationListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(EvaluationPeer::SITE_ID, SitePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EvaluationPeer::ECRITERIA_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EvaluationPeer::ECRITERIA_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Site';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'url'             => 'Text',
      'description'     => 'Text',
      'evaluation_list' => 'ManyKey',
    );
  }
}
