<?php

/**
 * Metric filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseMetricFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'description'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'evaluation_list' => new sfWidgetFormPropelChoice(array('model' => 'Site', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'description'     => new sfValidatorPass(array('required' => false)),
      'evaluation_list' => new sfValidatorPropelChoice(array('model' => 'Site', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('metric_filters[%s]');

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

    $criteria->addJoin(EvaluationPeer::METRIC_ID, MetricPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EvaluationPeer::SITE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EvaluationPeer::SITE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Metric';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'description'     => 'Text',
      'evaluation_list' => 'ManyKey',
    );
  }
}
