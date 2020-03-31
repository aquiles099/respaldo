<?php $only = 'only'; ?>
<?php
use App\Helpers\HUserType;
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
<?php $js =  ['js/includes/resellerCtrl.js']; ?>
<?php $__env->startSection('pageTitle', trans('messages.managenotications')); ?>
<?php $__env->startSection('icon-title'); ?>
  <i aria-hidden="true" class="fa fa-bell fa-fw"></i>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title', trans('messages.managenotications')); ?>

<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('title-actions'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="text-muted">
    <i aria-hidden="true" class="fa fa-eye"></i>
    <?php echo e(strtoupper(trans('messages.notificationsinfo'))); ?>

  </div>
  <div class="panel panel-default">
    <div class="panel-heading text-center">
      <span class="text-muted">
        <i aria-hidden="true" class="fa fa-bell fa-fw"></i>
        <?php echo e(trans('messages.managenotications')); ?>

      </span>
    </div>
    <div class="panel-body">
      <form class="" onsubmit="createLoad()" action="<?php echo e(asset('/account/notifications/settings')); ?>" method="post">
        <fieldset role="form">
          <table class="table table-striped table-hover table-responsive" id="dtble">
            <thead>
              <tr>
                <th style="text-align:center"><?php echo e(trans('messages.number')); ?></th>
                <th style="text-align:center"><?php echo e(trans('messages.description')); ?></th>
                <th style="text-align:center"><?php echo e(trans('messages.active')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($events as $key => $event): ?>
                <?php if(($event->active == '1')): ?>
                  <tr>
                    <td><?php echo e($key + 1); ?></td>
                    <td>
                      <?php if($event->id != 2): ?>
                        <?php echo e(strtoupper($event->name)); ?>

                        <?php if($event->id == 1): ?> <span><i class="fa fa-building-o" aria-hidden="true"></i></span> <?php endif; ?>
                        <?php if($event->id == 3): ?> <span><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span> <?php endif; ?>
                        <?php if($event->id == 4): ?> <span><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span> <?php endif; ?>
                        <?php if($event->id == 5): ?> <span><i class="fa fa-check" aria-hidden="true"></i></span> <?php endif; ?>
                        <?php if($event->id == 6): ?> <span><i class="fa fa-user" aria-hidden="true"></i></span> <?php endif; ?>
                      <?php else: ?>
                        <?php echo e(strtoupper($event->name)); ?>

                        <?php if($event->id == 2): ?> <span><i class="fa fa-cubes" aria-hidden="true"></i></span> <?php endif; ?>
                      <?php endif; ?>
                    </td>
                    <td>
                      <input type="checkbox" name="icsnu<?php echo e($event->id); ?>" value="<?php echo e($event->id); ?>" <?php foreach($user_notifications as $key => $value): ?><?php if($value->event == $event->id): ?> checked <?php endif; ?> <?php endforeach; ?>>
                    </td>
                  </tr>
                <?php endif; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
          <hr>
          <div class="text-muted" id="divButton">
              <button type="submit" class="pull-right btn btn-primary" id="submitBnt"><?php echo e(trans('messages.send')); ?></button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>