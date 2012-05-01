<?php

class swWidgetFormInputUploadify extends sfWidgetForm {
  
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addRequiredOption('script');
    $this->addRequiredOption('folder');
    $this->addOption('onComplete', 'default');
    $this->addOption('buttonText', 'default');
    $this->addOption('buttonImg', 'default');
    $this->addOption('buttonWidth', 'default');
    $this->addOption('buttonHeight', 'default');
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    static $nId = 1; //Diferencia las diferentes llamadas
    $nId++;
    $id = $this->generateId($name) . '_' . $nId;
    $options = $this->getUploadifyOptions();
    $template = "<div id='{$id}' class='sw_uploadify'
                      options='{$options}'>
                    <div id='{$id}_placeholder'></div>
                    <input id='{$id}_input' name='{$name}' value='{$value}' type='hidden'>
                 </div>";                
    return $template;
  }
  
  protected function getUploadifyOptions() {
    $options = '';
    if ($this->getOption('onComplete') !== 'default') {
      $options .= "onComplete:". $this->getOption('onComplete') . "|";
    }
    if ($this->getOption('buttonText') !== 'default') {
      $options .= "buttonText:". $this->getOption('buttonText') . "|";
      $options .= "buttonImg:''|";
    }
    if ($this->getOption('buttonImg') !== 'default') {
      $options .= "buttonImg:". $this->getOption('buttonImg') . "|";
    }
    if ($this->getOption('buttonWidth') !== 'default') {
      $options .= "width:". $this->getOption('buttonWidth') . "|";
    }
    if ($this->getOption('buttonHeight') !== 'default') {
      $options .= "buttonHeight:". $this->getOption('buttonHeight') . "|";
    }
    $options .= "script:". $this->getOption('script') . "|";
    $options .= "folder:". $this->getOption('folder');
    return $options;
  }
  
}