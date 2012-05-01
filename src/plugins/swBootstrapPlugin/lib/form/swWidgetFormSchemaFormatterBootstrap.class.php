<?php
/**
 * sfWidgetFormSchema formatter designed to work w/ Twitter's Bootstrap project
 * @link http://twitter.github.com/bootstrap/
 * 
 * @version 0.0.1
 * @author marcos.ibanez@surgicalworks.com.ar
 */

class swWidgetFormSchemaFormatterBootstrap extends sfWidgetFormSchemaFormatter {
  protected $rowFormat = '<div id="row_%rowId%" class="clearfix %error_class%">%label%<div class="input">%help%%field%%error%%hidden_fields%</div></div>';
  protected $helpFormat = '<span class="help-block">%help%</span>';
  protected $errorRowFormat = '<dt class="error">Errors:</dt><dd>%errors%</dd>';
  protected $errorListFormatInARow = '<span class="help-inline">%errors%</span>'; 
  protected $errorRowFormatInARow = '%error%<br />';
  protected $namedErrorRowFormatInARow = '<li>%name%: %error%</li>';
  protected $decoratorFormat = '<dl id="formContainer">%content%</dl>';
  
  public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null) {
    $s = simplexml_load_string($label);
    $rowId = 'unknow_' . time(); //In case that is not paraseable.
    if (isset($s ['for'])) {
      $rowId = $s ['for'];
    }
    return strtr($this->getRowFormat(), 
            array (
              '%rowId%' => $rowId, 
              '%label%' => $label, 
              '%field%' => $field, 
              '%error%' => $this->formatErrorsForRow($errors), 
              '%help%' => $this->formatHelp($help), 
              '%hidden_fields%' => null === $hiddenFields ? '%hidden_fields%' : $hiddenFields, 
              '%error_class%' => ((null !== $errors) && $errors) ? 'error' : '' 
            ));
  }
}