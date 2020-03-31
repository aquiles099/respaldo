<?php $js =  ['js/includes/prealertCtrl.js']; ?>
<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('prealert.list')); ?>
<?php $__env->startSection('title', trans('prealert.list')); ?>

<?php $__env->startSection('title-actions'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pre-title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('pages.admin.package.prealert.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-border table-hover" id="dtble" >
        <thead>
          <tr>
            <th class="text-center"><?php echo e(trans('prealert.code')); ?></th>
            <th class="text-center"><?php echo e(trans('prealert.user')); ?></th>
            <th class="text-center"><?php echo e(trans('prealert.service_order')); ?></th>
            <th class="text-center"><?php echo e(trans('prealert.package')); ?></th>
            <th class="text-center"><?php echo e(trans('prealert.date_arrived')); ?></th>
            <th class="text-center"><?php echo e(trans('prealert.actions')); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($prealerts as $key => $prealert): ?>
            <tr item="<?php echo e($prealert->toInnerJson()); ?>">
              <td><a class="infoRd" href="javascript:icsViewPrelert(<?php echo e($prealert->id); ?>)"><?php echo e($prealert->code); ?></a></td>
              <td><?php echo e($prealert->getUser->code); ?> <?php echo e($prealert->getUser->name); ?> <?php echo e($prealert->getUSer->last_name); ?></td>
              <td><?php echo e(isset($prealert->order_service) ? $prealert->order_service : trans('prealert.unknown')); ?></td>
              <td><?php if(isset($prealert->getPackage)): ?> <a class="infoRd" href="javascript:icsDetailsPackage(<?php echo e($prealert->getPackage->id); ?>, false)"><?php echo e($prealert->getPackage->code); ?></a> <?php else: ?> <?php echo e(trans('prealert.unknown')); ?> <?php endif; ?></td>
              <td>
                <span <?php if($prealert->date_arrived == date('Y-m-d')): ?> class="label label-success" style="font-size: 13px" <?php endif; ?>>
                  <?php echo e($prealert->date_arrived); ?>

                </span>
              </td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="icsPrealertDelete($(this))" ><i class="fa fa-trash"  title="<?php echo e(trans('messages.delete')); ?>"></i></a></li>
                  <li><a href="<?php echo e(asset("admin/package/prealert/{$prealert->id}")); ?>"><i class="fa fa-pencil" title="<?php echo e(trans('messages.edit')); ?>"></i></a></li>
                </ul>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>