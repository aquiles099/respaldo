<?php
use App\Models\Admin\Event;
use App\Models\Admin\User;

$user = User::find(Session::get('key-sesion')['data']->id);

if(isset($package) && !is_null($package->getLastEvent)) {
  $position = $package->getLastEvent->step;
}
else {
  $position = -1;
}
$events_num = Event::query()->where('active','=',1)->count();


?>
<?php $only = 'only'; ?>
<?php
use App\Helpers\HUserType;
use App\Helpers\HConstants;
use Carbon\Carbon;
/**
*
*/
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
  $today = Carbon::now()->format('Y-m-d');
  /**
  *
  */
?>
<?php $js =  ['js/includes/resellerCtrl.js']; ?>
<?php $__env->startSection('pageTitle', trans('menu.casillero')); ?>
<?php $__env->startSection('title', trans('menu.casillero')); ?>
<?php $__env->startSection('icon-title'); ?>
  <i aria-hidden="true" class="fa fa-cubes"></i>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title-actions'); ?>
<a href="<?php echo e(isset($filter) ? asset('account/') : '#section'); ?>" class="btn btn-primary" <?php if(!isset($filter)): ?> data-toggle="collapse" <?php endif; ?>>
  <span><i class="<?php echo e(isset($filter) ? 'fa fa-list' : 'fa fa-filter'); ?>"></i></span>
  <?php echo e(isset($filter) ? trans('messages.list') : trans('Historial')); ?>

</a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('body'); ?>
<?php if((Session::get('with')) == "successMessage"): ?>
<script type="text/javascript">
$(document).ready(function() {
  $('#pnlin').html('<i class="fa fa-spin fa-spinner"></i> Cargando...');
    setTimeout(function () {
      window.location.href = "asset('/')";
      <?php echo e(Session::set('with','')); ?>

  },2000);
});
</script>
<?php endif; ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('pages.user.filter',[
      'path' => 'account'
    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="panel panel-default usrtrck" id = "pnlin">
    <?php if($packages->count() == 0): ?>
    <div class="panel-heading text-center">
      <span class="text-muted">
          <?php echo e(trans('messages.noMomentPackages')); ?>

        <i class="fa fa-exclamation" aria-hidden="true"></i>
      </span>
    </div>
    <div class="panel-body">
    <?php else: ?>
    <div class="panel-heading text-center">
      <span class="text-muted">
        <i class="fa fa-cubes" aria-hidden="true"></i>
        <?php echo e(trans('messages.packages')); ?>

      </span>
    </div>
    <div class="panel-body">
      <table class="table table-responsive" id="dtble">
        <thead>
          <tr>
              <th style="text-align: center"><?php echo e(trans('messages.code')); ?></th>
              <th style="text-align: center"><?php echo e(trans('messages.tracking')); ?></th>
              <th style="text-align: center"><?php echo e(trans('messages.date')); ?></th>
              <th style="text-align: center"><?php echo e(trans('package.status')); ?></th>
              <th style="text-align: center"><?php echo e(trans('messages.progress')); ?></th>
              <th style="text-align: center"><?php echo e(trans('messages.invoice')); ?></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($packages as $package): ?>
            <tr>
              <td style="vertical-align:middle"><?php echo e($package->code); ?></td>
              <td style="vertical-align:middle"><a class="infoRd" href="javascript:details(<?php echo e($package->id); ?>)"><?php echo e($package->tracking); ?></a></td>
              <td style="vertical-align:middle"><?php echo e($package->created_at); ?></td>
              <td style="vertical-align:middle">
                <?php if($package->getLastEvent->step == 0): ?> <?php echo e($events[0]->name); ?> <?php endif; ?>
                <?php if($package->getLastEvent->step == 1): ?> <?php echo e($events[1]->name); ?> <?php endif; ?>
                <?php if($package->getLastEvent->step == 2): ?> <?php echo e($events[2]->name); ?> <?php endif; ?>
                <?php if($package->getLastEvent->step == 3): ?> <?php echo e($events[3]->name); ?> <?php endif; ?>
                <?php if($package->getLastEvent->step == 4): ?> <?php echo e($events[4]->name); ?> <?php endif; ?>
                <?php if($package->getLastEvent->step == 5): ?> <?php echo e($events[5]->name); ?> <?php endif; ?>
              </td >
              <td style="background-color:white; vertical-align:middle">
                <ul class="nav nav-wizard" style="padding-left: 6%">
                  <?php if($events_num == 1): ?>
                      <?php if($events[0]->active==1): ?><li style="width:100%;" <?php if($package->getLastEvent->step == 0): ?> class="active" <?php endif; ?>><a><?php echo e($events[0]->name); ?></a></li><?php endif; ?>
                      <?php if($events[1]->active==1): ?><li style="width:100%;" <?php if($package->getLastEvent->step == 1): ?> class="active" <?php endif; ?>><a><?php echo e($events[1]->name); ?></a></li><?php endif; ?>
                      <?php if($events[2]->active==1): ?><li style="width:100%;" <?php if($package->getLastEvent->step == 2): ?> class="active" <?php endif; ?>><a><?php echo e($events[2]->name); ?></a></li><?php endif; ?>
                      <?php if($events[3]->active==1): ?><li style="width:100%;" <?php if($package->getLastEvent->step == 3): ?> class="active" <?php endif; ?>><a><?php echo e($events[3]->name); ?></a></li><?php endif; ?>
                      <?php if($events[4]->active==1): ?><li style="width:100%;" <?php if($package->getLastEvent->step == 4): ?> class="active" <?php endif; ?>><a><?php echo e($events[4]->name); ?></a></li><?php endif; ?>
                      <?php if($events[5]->active==1): ?><li style="width:100%;" <?php if($package->getLastEvent->step == 5): ?> class="active" <?php endif; ?>><a><?php echo e($events[5]->name); ?></a></li><?php endif; ?>
                  <?php endif; ?>

                  <?php if($events_num == 2): ?>
                      <?php if($events[0]->active==1): ?><li style="width:50%;" <?php if($package->getLastEvent->step == 0): ?> class="active" <?php endif; ?>><a><?php echo e($events[0]->name); ?></a></li><?php endif; ?>
                      <?php if($events[1]->active==1): ?><li style="width:50%;" <?php if($package->getLastEvent->step == 1): ?> class="active" <?php endif; ?>><a><?php echo e($events[1]->name); ?></a></li><?php endif; ?>
                      <?php if($events[2]->active==1): ?><li style="width:50%;" <?php if($package->getLastEvent->step == 2): ?> class="active" <?php endif; ?>><a><?php echo e($events[2]->name); ?></a></li><?php endif; ?>
                      <?php if($events[3]->active==1): ?><li style="width:50%;" <?php if($package->getLastEvent->step == 3): ?> class="active" <?php endif; ?>><a><?php echo e($events[3]->name); ?></a></li><?php endif; ?>
                      <?php if($events[4]->active==1): ?><li style="width:50%;" <?php if($package->getLastEvent->step == 4): ?> class="active" <?php endif; ?>><a><?php echo e($events[4]->name); ?></a></li><?php endif; ?>
                      <?php if($events[5]->active==1): ?><li style="width:50%;" <?php if($package->getLastEvent->step == 5): ?> class="active" <?php endif; ?>><a><?php echo e($events[5]->name); ?></a></li><?php endif; ?>
                  <?php endif; ?>

                  <?php if($events_num == 3): ?>
                      <?php if($events[0]->active==1): ?><li style="width:33%;" <?php if($package->getLastEvent->step == 0): ?> class="active" <?php endif; ?>><a><?php echo e($events[0]->name); ?></a></li><?php endif; ?>
                      <?php if($events[1]->active==1): ?><li style="width:33%;" <?php if($package->getLastEvent->step == 1): ?> class="active" <?php endif; ?>><a><?php echo e($events[1]->name); ?></a></li><?php endif; ?>
                      <?php if($events[2]->active==1): ?><li style="width:33%;" <?php if($package->getLastEvent->step == 2): ?> class="active" <?php endif; ?>><a><?php echo e($events[2]->name); ?></a></li><?php endif; ?>
                      <?php if($events[3]->active==1): ?><li style="width:33%;" <?php if($package->getLastEvent->step == 3): ?> class="active" <?php endif; ?>><a><?php echo e($events[3]->name); ?></a></li><?php endif; ?>
                      <?php if($events[4]->active==1): ?><li style="width:33%;" <?php if($package->getLastEvent->step == 4): ?> class="active" <?php endif; ?>><a><?php echo e($events[4]->name); ?></a></li><?php endif; ?>
                      <?php if($events[5]->active==1): ?><li style="width:33%;" <?php if($package->getLastEvent->step == 5): ?> class="active" <?php endif; ?>><a><?php echo e($events[5]->name); ?></a></li><?php endif; ?>
                  <?php endif; ?>

                  <?php if($events_num == 4): ?>
                      <?php if($events[0]->active==1): ?><li style="width:25%;" <?php if($package->getLastEvent->step == 0): ?> class="active" <?php endif; ?>><a><?php echo e($events[0]->name); ?></a></li><?php endif; ?>
                      <?php if($events[1]->active==1): ?><li style="width:25%;" <?php if($package->getLastEvent->step == 1): ?> class="active" <?php endif; ?>><a><?php echo e($events[1]->name); ?></a></li><?php endif; ?>
                      <?php if($events[2]->active==1): ?><li style="width:25%;" <?php if($package->getLastEvent->step == 2): ?> class="active" <?php endif; ?>><a><?php echo e($events[2]->name); ?></a></li><?php endif; ?>
                      <?php if($events[3]->active==1): ?><li style="width:25%;" <?php if($package->getLastEvent->step == 3): ?> class="active" <?php endif; ?>><a><?php echo e($events[3]->name); ?></a></li><?php endif; ?>
                      <?php if($events[4]->active==1): ?><li style="width:25%;" <?php if($package->getLastEvent->step == 4): ?> class="active" <?php endif; ?>><a><?php echo e($events[4]->name); ?></a></li><?php endif; ?>
                      <?php if($events[5]->active==1): ?><li style="width:25%;" <?php if($package->getLastEvent->step == 5): ?> class="active" <?php endif; ?>><a><?php echo e($events[5]->name); ?></a></li><?php endif; ?>
                  <?php endif; ?>

                  <?php if($events_num == 5): ?>
                      <?php if($events[0]->active==1): ?><li style="width:20%;" <?php if($package->getLastEvent->step == 0): ?> class="active" <?php endif; ?>><a><?php echo e($events[0]->name); ?></a></li><?php endif; ?>
                      <?php if($events[1]->active==1): ?><li style="width:20%;" <?php if($package->getLastEvent->step == 1): ?> class="active" <?php endif; ?>><a><?php echo e($events[1]->name); ?></a></li><?php endif; ?>
                      <?php if($events[2]->active==1): ?><li style="width:20%;" <?php if($package->getLastEvent->step == 2): ?> class="active" <?php endif; ?>><a><?php echo e($events[2]->name); ?></a></li><?php endif; ?>
                      <?php if($events[3]->active==1): ?><li style="width:20%;" <?php if($package->getLastEvent->step == 3): ?> class="active" <?php endif; ?>><a><?php echo e($events[3]->name); ?></a></li><?php endif; ?>
                      <?php if($events[4]->active==1): ?><li style="width:20%;" <?php if($package->getLastEvent->step == 4): ?> class="active" <?php endif; ?>><a><?php echo e($events[4]->name); ?></a></li><?php endif; ?>
                      <?php if($events[5]->active==1): ?><li style="width:20%;" <?php if($package->getLastEvent->step == 5): ?> class="active" <?php endif; ?>><a><?php echo e($events[5]->name); ?></a></li><?php endif; ?>
                  <?php endif; ?>

                  <?php if($events_num == 6): ?>
                      <?php if($events[0]->active==1): ?><li style="width:16%;" <?php if($package->getLastEvent->step == 0): ?> class="active" <?php endif; ?>><a><?php echo e($events[0]->name); ?></a></li><?php endif; ?>
                      <?php if($events[1]->active==1): ?><li style="width:16%;" <?php if($package->getLastEvent->step == 1): ?> class="active" <?php endif; ?>><a><?php echo e($events[1]->name); ?></a></li><?php endif; ?>
                      <?php if($events[2]->active==1): ?><li style="width:16%;" <?php if($package->getLastEvent->step == 2): ?> class="active" <?php endif; ?>><a><?php echo e($events[2]->name); ?></a></li><?php endif; ?>
                      <?php if($events[3]->active==1): ?><li style="width:16%;" <?php if($package->getLastEvent->step == 3): ?> class="active" <?php endif; ?>><a><?php echo e($events[3]->name); ?></a></li><?php endif; ?>
                      <?php if($events[4]->active==1): ?><li style="width:16%;" <?php if($package->getLastEvent->step == 4): ?> class="active" <?php endif; ?>><a><?php echo e($events[4]->name); ?></a></li><?php endif; ?>
                      <?php if($events[5]->active==1): ?><li style="width:16%;" <?php if($package->getLastEvent->step == 5): ?> class="active" <?php endif; ?>><a><?php echo e($events[5]->name); ?></a></li><?php endif; ?>
                  <?php endif; ?>
                </ul>
              </td>
              <td style="vertical-align:middle">
              <?php if($package->invoice == false): ?>
                <?php if($package->last_event < HConstants::EVENT_DELIVERED): ?>
                  <a href="<?php echo e(asset("account/upload/{$package->id}")); ?>" title="<?php echo e(trans('messages.uploadFile')); ?>">
                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                  <?php echo e(trans('messages.load')); ?>

                  </a>
                <?php endif; ?>
              <?php else: ?>
                  <i class="fa fa-check" aria-hidden="true">
              <?php endif; ?>
              </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>