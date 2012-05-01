<?php

class swWidgetFormInputUploadifyPictures extends swWidgetFormInputUploadify {

  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addOption('width', '');
    $this->addOption('height', '');
    $this->addOption('max-width', '');
    $this->addOption('max-height', '');
    $this->addOption('placeholder-image', '');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {

    $id = $this->generateId($name) . '_' . md5(microtime());
    $width = $this->getOption('width');
    if($width!='') {
    	$width = 'width: ' . $width . ';';
    } else {
    	$width ='';
    }
    $height = $this->getOption('height');
    if($height!='') {
    	$height = 'height: ' . $height . ';';
    } else {
    	$height ='';
    }
    $maxwidth = $this->getOption('max-width');
    $maxheight = $this->getOption('max-height');
    $placeholderImage = $this->getOption('placeholder-image');
    if($placeholderImage!='') {
    	$placeholderImage = "background: url($placeholderImage) no-repeat 50% 50%; "
    	  . 'width: ' . $maxwidth . 'px;'
    	  . 'height: ' . $maxheight . 'px;';
    }
   	if($maxwidth!='') {
   		$maxwidth = 'max-width: ' . $maxwidth . 'px;';
   	} else {
   		$maxwidth ='';
   	}
   	if($maxheight!='') {
   		$maxheight = 'max-height: ' . $maxheight . 'px;';
   	} else {
   		$maxheight ='';
  	}    	
    $folder = $this->getOption('folder');
    $options = $this->getUploadifyOptions();
    $imgPath = str_replace('//', '/', ($folder . '/' . $value));

    if (!empty($value)) {
      $filePath = $_SERVER['DOCUMENT_ROOT'] . $imgPath;
      if(is_array(@getimagesize($filePath))) {
        $src = "src='{$imgPath}'";
        $placeholderImage = '';
      } else {
        $src = "src='/images/document.jpg'";
      }
    } else {
      $src = '';
    }
    $img = "<img class='preview' style='{$width} {$height} {$maxheight} {$maxwidth} {$placeholderImage}' data-placeholder-style='{$placeholderImage}' id='{$id}_image' {$src} />";

    $template = "<div id='{$id}' class='sw_uploadify'
                      options='{$options}|onComplete:sw_uploadify.updateImage'>
                    {$img}
                    <div id='{$id}_placeholder'></div>
                    <input id='{$id}_input' name='{$name}' value='{$value}' type='hidden'>
                 </div>";
    return $template;
  }

}