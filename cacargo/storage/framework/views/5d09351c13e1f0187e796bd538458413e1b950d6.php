<?php
use App\Helpers\HUserType;
use App\Helpers\HConstants;
?>
<?php $only = 'only'; ?>
<?php
  if (Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
<?php $js =  ['js/includes/resellerCtrl.js']; ?>
<?php $js =  ['js/includes/prealertCtrl.js']; ?>
<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('messages.listprealert')); ?>
<?php $__env->startSection('icon-title'); ?>
  <i aria-hidden="true" class="fa fa-flag"></i>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title', trans('messages.listprealert')); ?>

<?php $__env->startSection('title-actions'); ?>
<div class="btn-group" role="group" >
  <a href="<?php echo e(asset('account/prealert/new')); ?>" onclick="loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="<?php echo e(trans('messages.newprealert')); ?>">
    <i class="fa fa-plus" aria-hidden="true"></i>
    <?php echo e(trans('messages.create')); ?>

  </a>
  <a href="<?php echo e(isset($filter) ? asset('account/prealert') : '#section'); ?>" class="btn btn-primary" <?php if(!isset($filter)): ?> data-toggle="collapse" <?php endif; ?>>
    <span><i class="<?php echo e(isset($filter) ? 'fa fa-list' : 'fa fa-filter'); ?>"></i></span>
    <?php echo e(isset($filter) ? trans('messages.list') : trans('messages.filter')); ?>

  </a>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('pages.user.filter', [
      'path'  => 'account/prealert'
    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="panel panel-default" id="pnlin">
    <div class="panel-heading text-center">
      <span class="text-muted">
        <i class="fa fa-flag" aria-hidden="true"></i>
        <?php echo e(trans('messages.listprealert')); ?>

      </span>
    </div>
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive" id="dtble">
        <thead>
          <tr>
            <th style="text-align:center"><?php echo e(trans('prealert.code')); ?></th>
            <th style="text-align:center"><?php echo e(trans('prealert.order_service')); ?></th>
            <th style="text-align:center"><?php echo e(trans('prealert.provider')); ?></th>
            <th style="text-align:center"><?php echo e(trans('prealert.courier')); ?></th>
            <th style="text-align:center"><?php echo e(trans('prealert.date_arrived')); ?></th>
            <th style="text-align:center"><?php echo e(trans('prealert.actions')); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($prealerts as $key => $prealert): ?>
            <?php if(!isset($filter)): ?>
              <?php if($prealert->complete == HConstants::RESPONSE_NULL): ?>
                <tr>
                  <td><?php echo e($prealert->code); ?></td>
                  <td><a class="infoRd" href="javascript:icsViewPrelert(<?php echo e($prealert->id); ?>)"><?php echo e($prealert->order_service); ?></a></td>
                  <td><?php echo e($prealert->provider); ?></td>
                  <td><?php echo e($prealert->getCourier->name); ?></td>
                  <td><?php echo e($prealert->date_arrived); ?></td>
                  <td>
                    <ul class="table-actions">
                      <?php /*<li><a onclick="icsPrealertDelete(<?php echo e($prealert->id); ?>)" ><i class="fa fa-trash"  data-toggle="tooltip" title="<?php echo e(trans('prealert.deletep')); ?>"></i></a></li>*/ ?>
                      <li><a href="<?php echo e(asset("account/prealert/{$prealert->id}")); ?>" ><i class="fa fa-pencil"  data-toggle="tooltip" title="<?php echo e(trans('prealert.edit')); ?>"></i></a></li>
                    </ul>
                  </td>
                </tr>
              <?php endif; ?>
            <?php elseif($count > HConstants::EVENT_CERO): ?>
              <tr>
                <td><?php echo e($prealert->code); ?></td>
                <td><a class="infoRd" href="javascript:icsViewPrelert(<?php echo e($prealert->id); ?>)"><?php echo e($prealert->order_service); ?></a></td>
                <td><?php echo e($prealert->provider); ?></td>
                <td><?php echo e($prealert->getCourier->name); ?></td>
                <td><?php echo e($prealert->date_arrived); ?></td>
                <td>
                  <ul class="table-actions">
                    <?php /*<li><a onclick="icsPrealertDelete(<?php echo e($prealert->id); ?>)" ><i class="fa fa-trash"  data-toggle="tooltip" title="<?php echo e(trans('prealert.deletep')); ?>"></i></a></li>*/ ?>
                    <?php if($prealert->complete == HConstants::RESPONSE_NULL): ?>
                      <li><a href="<?php echo e(asset("account/prealert/{$prealert->id}")); ?>" ><i class="fa fa-pencil"  data-toggle="tooltip" title="<?php echo e(trans('prealert.edit')); ?>"></i></a></li>
                    <?php endif; ?>
                  </ul>
                </td>
              </tr>
            <?php endif; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>