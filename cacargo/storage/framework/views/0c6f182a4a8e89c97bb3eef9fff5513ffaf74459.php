<?php $buttonPadding =  20; ?>
<?php $user = 'user'; ?>
<?php $toolbar = 'toolbar'; ?>
<?php $only = 'only'; ?>
<?php $noTitle = 'noTitle'; ?>

<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('messages.terms')); ?>
<?php $__env->startSection('title', trans('messages.register')); ?>
<?php if(!isset($session) || $session == null): ?>
<?php $__env->startSection('toolbar-custom-pre'); ?>
  <li><a href="<?php echo e(asset('/register')); ?>" id ="drdusr"><i class="fa fa-user" aria-hidden="true"></i> <?php echo e(trans('messages.register')); ?></a></li>
<?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('body'); ?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="login-panel panel panel-default">
      <div class="panel-heading">
        <div class="text-center text-muted">
            <i class="fa fa-thumb-tack" aria-hidden="true"></i>
            <?php echo e(trans('messages.terms')); ?>

        </div>
      </div>
      <div class="panel-body" id="terms">
          <?php echo e(isset($terms) ? ($terms == '' ) ? trans('configuration.noTerms') : $terms : trans('configuration.noTerms')); ?>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>