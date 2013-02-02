<?php use_helper('I18N'); ?>
<div class="row-fluid">
	<div class="span6">
        <div>
          Reporte par el sitio <strong><?php echo SitePeer::getCurrent()->getUrl()?>
          </strong>
          <p>
            <?php SitePeer::getCurrent()->getDescription()?>
          </p>
        </div>
        <h2>Evaluación de Calidad: <?php echo $nivelObtenido ?></h2>
        <br>
        <?php $lastMetric = null ?>
        <?php foreach(SitePeer::getCurrent()->getEvaluations() as $evaluation): ?>
            <?php if($evaluation->getMetricId() != $lastMetric): ?>
                <?php if(null != $lastMetric): ?>
                    </tbody>
                </table>
                <?php endif ?>
                <h2><?php echo $evaluation->getMetric()->getName() ?></h2>
                <table width="90%">
                    <thead>
                       <tr>
                           <td width="45%"><strong>Nombre</strong></td>
                           <td width="44%" style="text-align: right"><strong>Valor Calculado</strong></td>
                           <td width="10%" style="text-align: right"><strong>Valor Crudo</strong></td>
                       </tr>
                    </thead>
                    <tbody>
                <?php $lastMetric = $evaluation->getMetricId() ?>
            <?php endif ?>
                <tr style="border-bottom: 1px grey solid">
                    <td style="font-style: italic;"><?php echo $evaluation->getEcriteria()->getName()?></td>
                    <td style="text-align: right"><?php echo $evaluation->getProcessedValue()?></td>
                    <td style="text-align: right"><?php echo $evaluation->getValue()?></td>
                </tr>
        <?php endforeach ?>
        <?php if(null != $lastMetric): ?>
            </table>
        <?php endif ?>
	</div>
</div>
