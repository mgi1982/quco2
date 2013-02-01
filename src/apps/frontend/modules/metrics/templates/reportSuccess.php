<?php use_helper('I18N'); ?>
Report!
<div class="row-fluid">
	<div class="span6">
		<?php if(isset($form)): ?>
			<form class="form-horizontal" action="" method="post">
				<legend>Por favor ingrese la descripcion del sitio</legend>
				<fieldset>
					<?php echo $form->renderHiddenFields()?>
					<div class="control-group <?php echo ($form['url']->hasError()) ? 'error' : ''?>">
						<?php echo $form['url']->renderLabel(null, array('class' => 'control-label'))?>
						<div class="controls">
							<?php echo $form['url']->render(array('class' => 'input-xlarge', 'readonly' => 'readonly'))?>
							<?php if($form['url']->hasError()): ?>
							<span class="help-inline"><?php echo __($form['url']->getError())?></span>
							<?php endif?>
							</div>
					</div>
					<div class="control-group <?php echo ($form['description']->hasError()) ? 'error' : ''?>">
						<?php echo $form['description']->renderLabel(null, array('class' => 'control-label'))?>
						<div class="controls">
							<?php echo $form['description']->render(array('class' => 'input-xlarge'))?>
							<?php if($form['description']->hasError()): ?>
							<span class="help-inline"><?php echo __($form['description']->getError())?></span>
							<?php endif?>
						</div>
					</div>
					<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="Guardar">
					</div>
				</fieldset>
			</form>
		<?php else: ?>
			<?php include_partial('global/site_name') ?>
		<?php endif?>
	</div>
</div>
