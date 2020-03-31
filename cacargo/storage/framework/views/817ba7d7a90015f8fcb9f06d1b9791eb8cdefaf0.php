<?php $buttonPadding =  20; ?>
<?php $toolbar = 'toolbar'; ?>
<?php $__env->startSection('pageTitle', trans('menu.dashboard')); ?>
<?php $__env->startSection('title', trans('menu.dashboard')); ?>
<?php $pageCSS =  'panel-white'; ?>

<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('title-actions'); ?>

<a class="btn btn-primary" href="<?php echo e(asset('/admin/package/prealert')); ?>" onclick="loadButton(this)"data-toggle="tooltip" data-placement="left" title="<?php echo e(trans('messages.dateprealerts')); ?>">
  <i aria-hidden="hidden" class="fa fa-flag"></i>
    <?php echo e(trans('menu.prealerts')); ?>

    <?php if(isset($today_prealerts) && $today_prealerts > 0): ?>
    <span class="badge">
      <?php echo e($today_prealerts); ?>

    </span>
    <?php endif; ?>
</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<div class="breadcrumb text-muted">
<?php echo e(trans('messages.resume')); ?>

    <span class="pull-right">
      <div  class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer">
          <span class="text-muted">
            <i class="fa fa-eye" aria-hidden="true"></i>
            <span class="" id="dateload"></span>
            <?php echo e(trans('messages.viewPackageOf')); ?> |
            <span id="selected_date">
              <?php if(isset($today)): ?>
                <?php echo e((($today == (date('Y-m-d'))) ? trans('messages.today') : $today )); ?>

                <?php else: ?>
                  <?php echo e(trans('messages.all_times')); ?>

                <?php endif; ?>
            </span>
            <span class="caret"></span>
          </span>
        </a>
        <ul class="dropdown-menu" id="dropdown">
          <li class="dropdown-header"><?php echo e(trans('messages.show')); ?></li>
          <li class="divider"></li>
          <li><a href="javascript:showDateDashboard(1)"><?php echo e(trans('messages.today')); ?> <span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(2)"><?php echo e(trans('messages.yesterday')); ?> <span class="pull-right"><i class="fa fa-undo" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(3)"><?php echo e(trans('messages.month')); ?> <span class="pull-right"><i class="fa fa-calendar-o" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(4)"><?php echo e(trans('messages.day')); ?>   <span class="pull-right"><i class="fa fa-calendar" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(5)"><?php echo e(ucwords(trans('messages.all'))); ?><span class="pull-right"><i class="fa fa-th-list" aria-hidden="true"></i></span></a></li>
        </ul>
      </div>
    </span>
</div>
<div class="row">
  <?php if(isset($events_num)): ?>
    <?php if($events_num == 5): ?>
      <div class="col-md-1">

      </div>
    <?php endif; ?>
    <?php if($events_num == 4): ?>
      <div class="col-md-2">

      </div>
    <?php endif; ?>
    <?php if($events_num == 3): ?>
      <div class="col-md-3">

      </div>
    <?php endif; ?>
    <?php if($events_num == 2): ?>
      <div class="col-md-4">

      </div>
    <?php endif; ?>
    <?php if($events_num == 1): ?>
      <div class="col-md-5">

      </div>
    <?php endif; ?>
  <?php endif; ?>
  <?php if((isset($events))&&($events[0]->active ==1)): ?>
  <div class="col-md-2">
    <?php if(isset($todayPackage)): ?>
      <div class="panel panel-primary">
        <div class="panel-heading"><h4 class=""><?php echo e(isset($events[0]) ?$events[0]->name : trans('menu.recibed')); ?></h4></div>
        <div class="panel-body pack">
            <span class="label label-default"> <?php echo e($todayPackage); ?> </span>
        </div>
        <?php foreach($mOffice as $office): ?>
        <div class="panel-footer dash" id="pnlin"><a href="javascript:details(1)"><?php echo e(trans('messages.details')); ?></a><span class="pull-right text-muted"><?php echo e($office->code); ?></span></div>
        <?php endforeach; ?>
     </div>
   <?php endif; ?>
  </div>
  <?php endif; ?>
  <?php /*Paquetes enviados en la fecha seleccionada*/ ?>
  <?php if((isset($events))&&($events[1]->active ==1)): ?>
  <div class="col-md-2">
    <div class="panel panel-green">
      <div class="panel-heading"> <h4 class=""><?php echo e(isset($events[1]) ?$events[1]->name : trans('menu.send')); ?></h4></div>
      <div class="panel-body pack">
        <?php if(isset($sendPackages)): ?>
          <span class="label label-default"> <?php echo e($sendPackages); ?> </span>
        <?php endif; ?>
      </div>
      <div class="panel-footer dash" id="pnlin"><a href="javascript:details(2)"><?php echo e(trans('messages.details')); ?></a></div>
    </div>
  </div>
  <?php endif; ?>
  <?php /*Paquetes en transito en la fecha seleccionada*/ ?>
  <?php if((isset($events))&&($events[2]->active ==1)): ?>
  <div class="col-md-2">
    <div class="panel panel-yellow">
      <div class="panel-heading"><h4 class=""><?php echo e(isset($events[2]) ?$events[2]->name : trans('package.inTransit')); ?></h4></div>
      <div class="panel-body pack">
        <?php if(isset($transitPackages)): ?>
          <span class="label label-default"> <?php echo e($transitPackages); ?> </span>
        <?php endif; ?>
      </div>
      <div class="panel-footer dash" id="pnlin"><a href="javascript:details(3)"><?php echo e(trans('messages.details')); ?></a></div>
    </div>
  </div>
  <?php endif; ?>
  <?php /*Paquetes en destino en la fecha seleccionada*/ ?>
  <?php if((isset($events))&&($events[3]->active ==1)): ?>
  <div class="col-md-2">
    <?php if(isset($arribedPackage)): ?>
      <div class="panel panel-default" id="pnlnoin">
        <div class="panel-heading"><h4 class=""><?php echo e(isset($events[3]) ?$events[3]->name : trans('package.destination')); ?></h4></div>
        <div class="panel-body pack">
            <span class="label label-default"> <?php echo e($arribedPackage); ?> </span>
        </div>
        <?php foreach($pOffice as $office): ?>
        <div class="panel-footer dash" id="pnlin"><a href="javascript:details(4)"><?php echo e(trans('messages.details')); ?></a> <span class="pull-right text-muted"><?php echo e($office->code); ?></span></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
  <?php endif; ?>
  <?php /*Paquetes sin factura en la fecha seleccionada*/ ?>
  <?php if((isset($events))&&($events[4]->active ==1)): ?>
  <div class="col-md-2">
    <?php if(isset($noInvoice)): ?>
      <div class="panel panel-red">
        <div class="panel-heading"><h4><?php echo e(isset($events[4]) ?$events[4]->name : trans('package.withOutInvoice')); ?></h4></div>
        <div class="panel-body pack">
            <span class="label label-default"> <?php echo e($noInvoice); ?> </span>
        </div>
        <div class="panel-footer dash" id="pnlin"><a href="javascript:details(5)"><?php echo e(trans('messages.details')); ?></a></div>
    </div>
    <?php endif; ?>
  </div>
  <?php endif; ?>
  <?php /*Paquetes entregados en la fecha seleccionada*/ ?>
  <?php if((isset($events))&&($events[5]->active ==1)): ?>
  <div class="col-md-2">
    <?php if(isset($delivered)): ?>
      <div class="panel panel-default" id="pnldelv" >
        <div class="panel-heading"><h4><?php echo e(isset($events[5]) ?$events[5]->name : trans('package.delivered')); ?></h4></div>
        <div class="panel-body pack">
            <span class="label label-default"> <?php echo e($delivered); ?> </span>
        </div>
        <div class="panel-footer dash" id="pnlin"><a href="javascript:details(6)"><?php echo e(trans('messages.details')); ?></a></div>
    </div>
    <?php endif; ?>
  </div>
  <?php endif; ?>
</div><!--
<div class="breadcrumb text-muted">
<?php echo e(trans('messages.visualizations')); ?>

</div>
<!--
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <?php if(isset($todayPackage) && isset($sendPackages) && isset($transitPackages) && isset($arribedPackage) && isset($noInvoice) && isset($delivered)): ?>
      <?php if($todayPackage == 0 && $sendPackages == 0 && $transitPackages == 0 && $arribedPackage == 0 && $noInvoice == 0 && $delivered == 0): ?>
      <div class="panel panel-heading text-center">
        <span class="text-muted"><?php echo e(trans('messages.noRegisterPackages')); ?> <i class="fa fa-exclamation" aria-hidden="true"></i></span>
      </div>
      <div class="panel-body">
      </div>
      <?php else: ?>
      <div class="panel-body">
        <script>chartNums(<?php echo e($todayPackage); ?>, <?php echo e($sendPackages); ?>, <?php echo e($transitPackages); ?>, <?php echo e($arribedPackage); ?> , <?php echo e($noInvoice); ?>, <?php echo e($delivered); ?>)</script>
        <div id="barchart_values" class="mainchart"></div>
      </div>
      <?php endif; ?>
    <?php endif; ?>
    </div>
  </div>
</div>-->
<!--
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
        <?php if(isset($mar) && isset($air)): ?>
          <?php if($mar == 0 && $air == 0): ?>
            <div class="panel panel-heading text-center">
              <span class="text-muted"><?php echo e(trans('messages.noRegisterPackages')); ?> <i class="fa fa-exclamation" aria-hidden="true"></i></span>
            </div>
            <div class="panel-body">
            </div>
          <?php else: ?>
            <div class="panel-body">
              <script>chartType(<?php echo e($mar); ?>,<?php echo e($air); ?>)</script>
              <div id="donutchart" class="chart"></div>
            </div>
          <?php endif; ?>
        <?php endif; ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <?php if(isset($invoicePackages) && isset($noInvoicePackages)): ?>
        <?php if($invoicePackages == 0 && $noInvoicePackages == 0): ?>
        <div class="panel panel-heading text-center">
          <span class="text-muted"><?php echo e(trans('messages.noRegisterPackages')); ?> <i class="fa fa-exclamation" aria-hidden="true"></i></span>
        </div>
        <div class="panel-body">
        </div>
        <?php else: ?>
        <div class="panel-body">
          <script>mainChart(<?php echo e($invoicePackages); ?>,<?php echo e($noInvoicePackages); ?>)</script>
          <div id="mainchart" class="chart"></div>
        </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</div>-->
<!--
<div class="breadcrumb text-muted">
<?php echo e(trans('messages.shortcuts')); ?>

</div>

<div class="row">
  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="<?php echo e(asset('admin/package')); ?>"class="infoRd"><i class="fa fa-cube" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class=""><span class="text-center"><?php echo e(trans('menu.packages')); ?></span></h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="<?php echo e(asset('admin/receipt/read')); ?>"class="infoRd"><i class="fa fa-file-text fa-fw" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class="text-center"><?php echo e(trans('menu.billing')); ?></h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="<?php echo e(asset('admin/company')); ?>"class="infoRd"><i class="fa fa-briefcase" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class=""><span class="text-center"><?php echo e(trans('menu.companies')); ?></span></h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="<?php echo e(asset('admin/service')); ?>"class="infoRd"><i class="fa fa-random" aria-hidden="true"></i></a></h1>
      </div>
     <div class="panel-heading"><h4 class=""><span class="text-center"><?php echo e(trans('menu.services')); ?></span></h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="<?php echo e(asset('admin/category')); ?>"class="infoRd"><i class="fa fa-table" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class=""><span class="text-center"><?php echo e(trans('menu.category')); ?></span></h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="<?php echo e(asset('admin/courier')); ?>"class="infoRd"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class=""><span class="text-center"><?php echo e(trans('menu.courier')); ?></span></h4></div>
    </div>
  </div>
</div>-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>