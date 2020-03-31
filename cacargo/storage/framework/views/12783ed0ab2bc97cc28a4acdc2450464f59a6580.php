<?php $js =  ['js/includes/userCtrl.js']; ?>
<?php $__env->startSection('pageTitle', trans('user.create')); ?>
<?php $__env->startSection('title', trans('user.create')); ?>

<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pre-title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title-actions'); ?>
  <div class="btn-group" role="group">
    <a href="<?php echo e(asset('admin/users')); ?>" onclick="loadButton(this)" class="btn btn-primary" title="<?php echo e(trans('user.list')); ?>">
      <i class="fa fa-list" aria-hidden="true"></i>
      <?php echo e(trans('messages.list')); ?>

    </a>
  </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('pages.admin.user.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="panel panel-default">
  <div class="panel-body">
  <?php echo $__env->make('pages.admin.user.form', [
    'path' => '/admin/user/new'
  ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>