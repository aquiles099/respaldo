<?php $buttonPadding =  20; ?>
<?php $user = 'user'; ?>
<?php $toolbar = 'toolbar'; ?>
<?php $only = 'only'; ?>
<?php $noTitle = 'noTitle'; ?>

<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('messages.recoverPassword')); ?>
<?php $__env->startSection('title', trans('messages.recoverPassword')); ?>
<?php $__env->startSection('toolbar-custom-pre'); ?>
  <li><a href="<?php echo e(asset('/login')); ?>" id ="drdusr"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo e(trans('messages.logIn')); ?></a></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="login-panel panel panel-default">
      <div class="panel-heading">
        <div class="text-center text-muted">
          <i aria-hidden="true" class="fa fa-lock"></i>
            <?php echo e(trans('messages.recoverPassword')); ?>

        </div>
      </div>
      <div class="panel-body">
        <form onsubmit="submitForm()" role="form" method="post" action="<?php echo e(asset('/recover-password')); ?>">
          <fieldset>
            <!---->
            <?php echo e(csrf_field()); ?>

            <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" >
                <input class="form-control" placeholder="<?php echo e(trans('messages.email')); ?>" name="email" id="email" type="email" required="true" autofocus value="<?php echo e(Input::get('email')); ?>">
                <?php echo $__env->make('errors.field', ['field' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <!-- Change this to a button or input when using this as a form -->
            <div class="pull-left text-muted" id="loadRecover"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo e(trans('messages.mailNotify')); ?></div>
            <button type="submit" class="btn btn-primary pull-right"><?php echo e(trans('messages.send')); ?></button>
            <a href="<?php echo e(asset('/help')); ?>" target="blank" class="btn pull-right" style="margin-right:10px"><?php echo e(trans('messages.help')); ?></a>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>