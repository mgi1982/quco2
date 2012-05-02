<?php use_helper('I18N'); ?>
<?php
$route = $sf_context->getRouting()->getCurrentInternalUri(true);
?>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse"
        data-target=".nav-collapse"> <span class="icon-bar"></span> <span
        class="icon-bar"></span> <span class="icon-bar"></span>
      </a> <a class="brand" href="javascript:(function(){<?php include_partial('global/bookmarklet')?>})();">Quco2</a>
      <?php if($sf_user->isAuthenticated()): ?>
      <div class="btn-group pull-right">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="icon-user"></i> <?php echo $sf_user ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <?php if($sf_user->isSuperAdmin()): ?>
          <li><?php echo link_to(__('Users CRUD'), '@sf_guard_user')?></li>
          <li><?php echo link_to(__('Metrics CRUD'), '@metric')?></li>
          <!-- <li><?php echo link_to(__('Criterias CRUD'), '@ecriteria')?></li> -->
          <li class="divider"></li>
          <?php endif ?>
          <li><?php echo link_to(__('Logout'), '@sf_guard_signout')?></li>
        </ul>
      </div>
      <div class="nav-collapse">
        <ul class="nav">
        <?php foreach(MetricQuery::create()->find() as $metric): ?>
          <li<?php echo (('@metric_load?id=' . $metric->getId()) == $route)? ' class="active"' : ''?>><?php echo link_to($metric->getName(), '@metric_load?id=' . $metric->getId())?></li>
        <?php endforeach;?>
        </ul>
      </div>
      <?php endif ?>
      <!--/.nav-collapse -->
    </div>
  </div>
</div>
