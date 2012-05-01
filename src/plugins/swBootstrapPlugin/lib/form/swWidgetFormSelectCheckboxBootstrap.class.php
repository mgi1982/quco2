<?php
/**
 *  formatter designed to work w/ Twitter's Bootstrap project
 * @link http://twitter.github.com/bootstrap/
 * 
 * @version 0.0.1
 * @author marcos.ibanez@surgicalworks.com.ar
 */

class swWidgetFormSelectCheckboxBootstrap extends sfWidgetFormSelectCheckbox
{
  protected function formatChoices($name, $value, $choices, $attributes)
  {
    $inputs = array();
    foreach ($choices as $key => $option)
    {
      $baseAttributes = array(
        'name'  => $name,
        'type'  => 'checkbox',
        'value' => self::escapeOnce($key),
        'id'    => $id = $this->generateId($name, self::escapeOnce($key)),
      );

      if ((is_array($value) && in_array(strval($key), $value)) || strval($key) == strval($value))
      {
        $baseAttributes['checked'] = 'checked';
      }

      $inputs[$id] = array(
        'input' => $this->renderTag('input', array_merge($baseAttributes, $attributes)),
        'label' => $this->renderContentTag('span', self::escapeOnce($option), array('for' => $id)),
      );
    }
    return call_user_func($this->getOption('formatter'), $this, $inputs);
  }
  
  public function formatter($widget, $inputs)
  {
    $rows = array();
    foreach ($inputs as $input)
    {
      $rows[] = $this->renderContentTag('li', $this->renderContentTag('label', $input['input'].$this->getOption('label_separator').$input['label']));
    }

    return !$rows ? '' : $this->renderContentTag('ul', implode($this->getOption('separator'), $rows), array('class' => $this->getOption('class')));
  }
}
