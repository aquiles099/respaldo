<?php $js =  ['js/includes/packagecurriersCtrl.js']; ?>
<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('package.createcurriers')); ?>
<?php $__env->startSection('title', trans('package.createcurriers')); ?>

<?php $__env->startSection('pre-title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title-actions'); ?>
  <div class="btn-group" role="group">
    <a href="<?php echo e(asset('admin/packagelist')); ?>" onclick="javascript:loadButton(this)" class="btn btn-primary" title="<?php echo e(trans('package.list')); ?>">
      <i class="fa fa-list" aria-hidden="true"></i>
      <?php echo e(trans('messages.list')); ?>

    </a>
  </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('pages.admin.package.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="panel panel-default">
  <div class="panel-body">
  <?php echo $__env->make('pages.admin.packagecurriers.form', [
    'path' => '/admin/packagecurriers/new'
  ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('onready'); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>