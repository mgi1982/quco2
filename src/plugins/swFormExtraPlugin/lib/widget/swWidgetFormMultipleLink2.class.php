<?php

class swWidgetFormMultipleLink2 extends sfWidgetForm {
  
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addRequiredOption('add_action');
    $this->addRequiredOption('del_action');
    $this->addRequiredOption('related_form_id');
    $this->addOption('method');
    $this->setOption('method', 'retrieveByPKs');
    $this->addOption('related_id');
    $this->addRequiredOption('model');
  }
  
  public function render($name, $value = null, $attributes = array(), 
                         $errors = array())
  {
    
    $model = $this->getOption('model');
    $modelPeer = $model.'Peer';
    $modelMethod = $this->getOption('method');
    $related_id = $this->getOption('related_id');
    $dataObjects = $modelPeer::$modelMethod($related_id);    
    $id = $this->generateId($name);
    $add_action = $this->getOption('add_action');
    $del_action = $this->getOption('del_action');
    $related_form_id = $this->getOption('related_form_id'); 
    $currentItems = '';
    
    foreach($dataObjects as $items) {
      $currentItems .= '<div class="multiple_item">
                          <label for="link_' . $items->getId() . '">' . $items->getTitle() . '</label>
                          <input readonly name ="link_' . $items->getId() . '" value="' . $items->getLink() . '" />
                          <span class="delete" lid="' . $items->getId() . '"> X </span>
                        </div>';
    }
   
    $template = "<div id='{$id}' class='multiple_widget' add_action='$add_action' 
                      del_action='$del_action' related_form_id='$related_form_id'>
                    <div class='links2'>
                      $currentItems
                    </div>
                    <div>
                        <input id='{$id}_title' name='title' value='' class='multiple_label'/>
                        <span class='http'>http://</span>
                        <input id='{$id}_link' name='link' value='' class='multiple_input' />
                    </div>
                    <div class='row'>
                      <div class='btn span1'>
                        Add
                      </div>
                      <div class='msg span4'></div>
                    </div>
                 </div>";
    $template .= '<script>' . 
        file_get_contents(dirname(__FILE__).'/swWidgetFormMultipleLink.js') 
        .'</script>';
    
    return $template;
  }
  
}