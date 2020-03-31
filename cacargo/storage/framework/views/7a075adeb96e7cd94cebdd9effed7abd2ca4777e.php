<?php $js =  ['js/includes/packagecurriersCtrl.js']; ?>
<?php $__env->startSection('pageTitle', trans('package.editco')); ?>
<?php $__env->startSection('title', trans((!$readonly) ? 'package.editco' : 'package.view')); ?>

<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pre-title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title-actions'); ?>
  <div class="btn-group" role="group" item="<?php echo e($package->toInnerJson()); ?>">
    <a href="<?php echo e(asset('admin/packagelist')); ?>" onclick="javascript:loadButton(this)" class="btn btn-default" title="<?php echo e(trans('package.list')); ?>">
      <i class="fa fa-list" aria-hidden="true"></i>
      <?php echo e(trans('messages.list')); ?>

    </a>
    <?php if(!isset($readonly) || !$readonly): ?>
      <a onclick="packageDelete($(this), false)" class="btn btn-default" title="<?php echo e(trans('messages.delete')); ?>">
        <i class="fa fa-times" aria-hidden="true"></i>
        <?php echo e(trans('messages.delete')); ?>

      </a>
    <?php endif; ?>
  </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('pages.admin.package.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="panel panel-default">
  <div class="panel-body">
  <?php echo $__env->make('pages.admin.packagecurriers.form', [
    'path' => "/admin/packagecurriers/{$package->id}"
  ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('onready'); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>