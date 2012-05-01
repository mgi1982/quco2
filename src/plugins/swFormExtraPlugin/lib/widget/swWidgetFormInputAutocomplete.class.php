<?php

/**
 * swWidgetFormInputAutocomplete an input box with auto complete, usefull
 * for multiple selections.
 *
 * Requires jQuery UI
 *
 * @package    symfony
 * @subpackage widget
 * @author     Casiva Agustin <agustin.casiva@surgicalworks.com.ar>
 */
class swWidgetFormInputAutocomplete extends sfWidgetFormInput
{
  /**
   * Configures the current widget.
   *
   * @param array $options     An array of options
   *   Required: model (UserProfile, Role, Tag)
   *   Required: searchUrl (The Source of Ajax Data for autocomplete).
   * @param array $attributes  An array of default HTML attributes
   *
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->setOption('type', 'text');

    $this->addOption('method');
    $this->setOption('method', 'retrieveByPKs');

    $this->addOption('allow_duplicated_values');
    $this->setOption('allow_duplicated_values', 'false');

    $this->addOption('unique_value');
    $this->setOption('unique_value', 'false');

    $this->addOption('get_id_method');
    $this->setOption('get_id_method', 'getId');

    $this->addOption('get_id_method');
    $this->setOption('get_id_method', 'getId');

    $this->addOption('minLength');
    $this->setOption('minLength', 0);
    
    $this->addRequiredOption('model');
    $this->addRequiredOption('searchUrl');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $model = $this->getOption('model');
    $searchUrl = $this->getOption('searchUrl');
    $minLength = $this->getOption('minLength');
    $modelPeer = $model.'Peer';
    $modelMethod = $this->getOption('method');
    $allowDuplicatedValues = $this->getOption('allow_duplicated_values');
    $uniqueValue = $this->getOption('unique_value');
    $id = $this->generateId($name);
    $dataObjects = $modelPeer::$modelMethod($value);
    $getIdMethod = $this->getOption('get_id_method');
    if($getIdMethod!=='getId') {
      $custom_get_id = 'true';
    } else {
      $custom_get_id = 'false';
    }


    if(isset($attributes) && is_array($attributes) && count($attributes)) {
      foreach ($attributes as $k => $v) {
        $attr[] = $k . '="' . $v . '"';
      }
      $attr = implode(' ', $attr);
    } else {
      $attr = '';
    }
    if(isset($attr['placeholder']) && count($dataObjects)) {
      $val = ' ';
    } else {
      $val = '';
    }
    $out = '';
    $out .= "<input type='text' name='{$name}_s' id='$id' {$attr} value='{$val}'/>";
    $out .= "<div id='{$id}_values' class='values'>";
    foreach($dataObjects as $dataObject) {
      $out .= "<span class='value item' lid='{$dataObject->$getIdMethod()}'>
               <span class=\"label big tagfield\">{$dataObject}
               <span class=\"radio_close\">x</span>
               <input type='checkbox' name='{$name}[]'
                   value='{$dataObject->$getIdMethod()}'
                   iid='{$dataObject->$getIdMethod()}'
                   checked='true'
                   class='delete_item_{$model} invisible' />&nbsp;</span><br style='clear: both;' />
               </span>";
      if ($uniqueValue !== 'false') {
          break;
      }
      if($allowDuplicatedValues=='false') {
        $val = $dataObject->$getIdMethod();
        if(is_string($dataObject->$getIdMethod())) {
          $alreadyLoaded[] = '"' . $val . '"';
        } else {
          $alreadyLoaded[] = $val;
        }
      }
    }

    if(isset($alreadyLoaded) && $allowDuplicatedValues=='false') {
      $alreadyLoaded = implode(',', $alreadyLoaded);
    } else {
      $alreadyLoaded = '';
    }

    $out .= '</div>';

    $out .= <<<EOT
    <script type="text/javascript">
      if(!{$allowDuplicatedValues}) {
        var alreadyLoaded_{$id} = [{$alreadyLoaded}];
      }
      $(document).ready(function(){
        $('#$id').autocomplete({
            source: surgical.url_for('$searchUrl'),
            minLength: {$minLength},
            select: function( event, ui ) {
              var allowDuplicatedValues = {$allowDuplicatedValues};
              var uniqueValue = {$uniqueValue};
              if(!allowDuplicatedValues) {
              	if(!isNaN(parseInt(ui.item.id)) || {$custom_get_id}) {
              	  if(alreadyLoaded_{$id}.indexOf(ui.item.id)!=-1) {
              	    return false;
  			      } else {
              	    alreadyLoaded_{$id}.push(ui.item.id);
              	  }
              	} else {
              	  if(ui.item.label in alreadyLoaded_{$id}) {
              	    return false;
              	  } else {
              	    alreadyLoaded_{$id}.push(ui.item.label);
              	  }
              	}
              }
              if(uniqueValue) {
                $('#{$id}_values').html('');
              }
              var newItem = '<span class="value item" iid="'
                + ui.item.id + '"><span class=\"label big tagfield\">'
                + ui.item.label + '<span class=\"radio_close\">x</span>'
                + '<input type="checkbox" name="{$name}[]" value="' + ui.item.id
                + '" ' + 'iid="' + ui.item.id + '" checked="true" '
                + 'class="delete_item_{$model} invisible" />&nbsp;</span><br style="clear: both;" /></span>';
              $('#{$id}_values').append(newItem);
              $('#{$id}').val(' ');
            },
            close: function(event, ui) {
              $('#$id').val(' ');
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
          return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append('<a>' + item.label + '</a>')
            .appendTo( ul );
        };
        $(".delete_item_{$model}").live('click', function(event) {
          target = $(event.target);
	      if(alreadyLoaded_{$id}.length) {
            remove = alreadyLoaded_{$id}.indexOf(target.val());
            if(remove==-1) {
              remove = alreadyLoaded_{$id}.indexOf(parseInt(target.val()));
            }
            if(remove!=-1) {
              alreadyLoaded_{$id}.splice(remove, 1);
            }
          }
          target.parent().remove();
          target.css('display', 'none');
          $( "#$id").val('');
        });
        $('#$id').click(function () {
            $('#$id').autocomplete('option', 'minLength', 0)
              .autocomplete('search', $('#$id').val())
              .autocomplete('option', 'minLength', {$minLength});
        });
      });
    </script>

EOT;
    return $out;

  }

}
