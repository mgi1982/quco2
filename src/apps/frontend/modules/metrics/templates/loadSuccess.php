<?php use_helper('I18N'); ?>
<div class="row-fluid">
	<div class="span6">
		<?php include_partial('global/site_name') ?>
		<form class="form-horizontal" action="" method="post">
			<legend><?php echo $metric->getName()?></legend>
			<fieldset>
				<?php echo $form->renderHiddenFields()?>
				<?php foreach($form as $key => $field): ?>
					<?php if($key !== '_csrf_token'): ?>
					<div class="control-group <?php echo ($field->hasError()) ? 'error' : ''?>">
						<?php echo $field->renderLabel(null, array('class' => 'control-label'))?>
						<div class="controls">
							<?php echo $field->render()?>
							<?php if($field->hasError()): ?>
							<span class="help-inline"><?php echo __($field->getError())?></span>
							<?php endif?>
						</div>
					</div>
					<?php endif ?>
				<?php endforeach ?>
				<div class="form-actions">
				    <?php if(isset($prevForm)): ?>
                    <a class="btn" href="<?php echo $prevForm ?>">Anterior</a>
                    <?php endif ?>
					<input type="submit" class="btn btn-primary" value="Guardar" />
					<?php if(isset($nextForm)): ?>
					<a class="btn" href="<?php echo $nextForm ?>">Siguiente</a>
					<?php endif ?>
				</div>
			</fieldset>
		</form>
	</div>
</div>