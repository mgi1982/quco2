<?php use_helper('I18N'); ?>
<div class="row-fluid">
	<div class="span6">
		<form class="form-horizontal" action="" method="post">
			<legend><?php echo $metric->getName()?></legend>
			<fieldset>
				<?php echo $form->renderHiddenFields()?>
				<?php foreach($form as $key => $field)?>
					<?php if($key !== '_csrf_token'): ?>
					<div class="control-group <?php echo ($field->hasError()) ? 'error' : ''?>">
						<?php echo $field->renderLabel(null, array('class' => 'control-label'))?>
						<div class="controls">
							<?php echo $field->render(array('class' => 'input-xlarge'))?>
							<?php if($field->hasError()): ?>
							<span class="help-inline"><?php echo __($field->getError())?></span>
							<?php endif?>
						</div>
					</div>
					<?php endif ?>
				<div class="form-actions">
					<input type="submit" class="btn btn-primary" value="Guardar">
				</div>
			</fieldset>
		</form>
	</div>
</div>