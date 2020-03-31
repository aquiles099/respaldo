<?php $js =  ['js/includes/transportTypeCtrl.js']; ?>
<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('transportType.list')); ?>
<?php $__env->startSection('title', trans('transportType.list')); ?>

<?php $__env->startSection('pre-title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title-actions'); ?>
<a href="<?php echo e(asset('admin/typeTransports/new')); ?>" onclick="loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="<?php echo e(trans('transportType.create')); ?>">
  <i class="fa fa-plus" aria-hidden="true"></i>
  <?php echo e(trans('messages.create')); ?>

</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('pages.admin.transportType.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive text-center" id="dtble">
        <thead>
          <tr>
            <th><?php echo e(trans('transportType.code')); ?></th>
            <th><?php echo e(trans('transportType.name')); ?></th>
            <th><?php echo e(trans('transportType.type')); ?></th>
            <th><?php echo e(trans('transportType.price')); ?></th>
            <th><?php echo e(trans('transportType.actions')); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($transport_types as $key => $value): ?>
            <tr item="<?php echo e($value); ?>">
              <td><a class="infoRd" href="javascript:details(<?php echo e($value->id); ?>)"><?php echo e($value->code); ?></a></td>
              <td style="text-transform:capitalize;"><?php echo e($value->name); ?></td>
              <td style="text-transform:capitalize;"><?php echo e($value->getTransport->spanish); ?></td>
              <td><?php echo e($value->price); ?></td>
              <td>
                <ul class="table-actions" style="text-align: center;display: inline;">
                  <li><a onclick="icstransportTypeDelete($(this))"><i class="fa fa-trash-o"  title="<?php echo e(trans('messages.delete')); ?>"></i></a></li>
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