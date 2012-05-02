<?php
/**
 *  formatter designed to work w/ Twitter's Bootstrap project
 * @link http://twitter.github.com/bootstrap/
 * 
 * @version 0.0.1
 * @author marcos.ibanez@surgicalworks.com.ar
 */

class swWidgetFormSelectRadioBootstrap extends sfWidgetFormSelectRadio
{
  protected function formatChoices($name, $value, $choices, $attributes)
  {
    $inputs = array();
    foreach ($choices as $key => $option)
    {
      $baseAttributes = array(
        'name'  => substr($name, 0, -2),
        'type'  => 'radio',
        'value' => self::escapeOnce($key),
        'id'    => $id = $this->generateId($name, self::escapeOnce($key)),
      );

      if (strval($key) == strval($value === false ? 0 : $value))
      {
        $baseAttributes['checked'] = 'checked';
      }

      $inputs[$id] = array(
        'input' => $this->renderTag('input', array_merge($baseAttributes, $attributes)),
        'label' => $option,
      );
    }
    return call_user_func($this->getOption('formatter'), $this, $inputs);
  }

  public function formatter($widget, $inputs)
  {
    $rows = array();
    foreach ($inputs as $input)
    {
      $rows[] = $this->renderContentTag('label', $input['input'].$this->getOption('label_separator').$input['label'], array('class' => $this->getOption('class')));
    }

    return !$rows ? '' : implode('', $rows);
  }
}
