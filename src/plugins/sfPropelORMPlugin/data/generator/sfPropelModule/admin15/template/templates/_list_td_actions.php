<td>
  <ul class="sf_admin_td_actions">
<?php foreach ($this->configuration->getValue('list.object_actions') as $name => $params): ?>
<?php if (isset($params['condition'])): ?>
  [?php if ( <?php echo ( isset( $params['condition']['invert'] ) && $params['condition']['invert'] ? '!' : '') . '$' . $this->getSingularName( ) . '->' . $params['condition']['function'] ?>( <?php echo ( isset( $params['condition']['params'] ) ? $params['condition']['params'] : '' ) ?> ) ): ?] 
<?php endif ?>
    <?php if ('_delete' == $name): ?>
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
    
    <?php elseif ('_edit' == $name): ?>
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToEdit($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
    
    <?php elseif ('_move_up' == $name): ?>
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToMoveUp($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
    
    <?php elseif ('_move_down' == $name): ?>
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToMoveDown($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
    
    <?php else: ?>
        <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
          <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
    
        </li>
    <?php endif; ?>
  <?php if ( isset( $params['condition'] ) ): ?>
    [?php endif; ?]
  <?php endif; ?>
<?php endforeach; ?>
  </ul>
</td>
