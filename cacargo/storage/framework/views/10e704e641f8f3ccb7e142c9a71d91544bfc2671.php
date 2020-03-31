<?php $js =  ['js/includes/packageCtrl.js']; ?>
<?php $__env->startSection('pageTitle', trans('package.packages')); ?>
<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('title', trans('package.packages')); ?>

<?php $__env->startSection('title-actions'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pre-title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('pages.admin.package.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="panel panel-default  showpack" id="pnlin">
    <div class="panel-body" >
      <table class="table table-striped table-border table-hover" id="dtble" >
        <thead>
          <tr>
            <th><?php echo e(trans('messages.code')); ?></th>
            <th><?php echo e(trans('messages.tracking')); ?></th>
            <th><?php echo e(trans('messages.client')); ?></th>
            <th><?php echo e(trans('messages.invoice')); ?></th>
            <th><?php echo e(trans('package.registred')); ?></th>
            <th><?php echo e(trans('messages.actions')); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data as $row): ?>
            <tr item="<?php echo e($row->toInnerJson()); ?>">
              <td><a class="infoRd" href="javascript:detailspackage(<?php echo e($row->id); ?>, 'true')"><?php echo e($row->code); ?></a></td>
              <td><?php echo e($row->tracking); ?></td>
              <td><?php echo e((isset($row->to_client) ? $row->getToClient['code']." ".$row->getToClient['name'] : $row->getToUser['code']." ".$row->getToUser['name'])); ?></td>
              <td><?php if($row->invoice == 0): ?>
                <a href="javascript:upload(<?php echo e($row->id); ?>)">
                  <i class="fa fa-times" aria-hidden="true"></i>
                </a>
                <?php else: ?>
                <i class="fa fa-check" aria-hidden="true"></i>
                <?php endif; ?></td>
              <td><?php echo e($row->created_at); ?></td>
              <td>
                <ul class="table-actions">

                  <li><a onclick="packageDelete($(this))" ><i class="fa fa-trash"  title="<?php echo e(trans('messages.delete')); ?>"></i></a></li>
                  <?php if(isset($row->from_courier)): ?>
                    <li><a href="<?php echo e(asset("admin/packagecurriers/{$row->id}")); ?>"><i class="fa fa-pencil" title="<?php echo e(trans('messages.edit')); ?>"></i></a></li>
                  <?php else: ?>
                    <li><a href="<?php echo e(asset("admin/package/{$row->id}")); ?>"><i class="fa fa-pencil" title="<?php echo e(trans('messages.edit')); ?>"></i></a></li>
                  <?php endif; ?>
                  <!-- <li><a href="<?php echo e(asset("admin/package/{$row->id}")); ?>/print" target="_blank"><i class="fa fa-ticket"    title="<?php echo e(trans('messages.tickets')); ?>" ></i></a></li> -->
                  <li><a target="_blank" href="javascript:detailsreceipt(<?php echo e($row->id); ?>)" ><i class="fa fa-list"    title="<?php echo e(trans('messages.details')); ?>" ></i></a></li>
                  <!-- <li><a target="_blank" href="<?php echo e(asset("admin/package/{$row->id}")); ?>/invoice" ><i class="fa fa-file-pdf-o"    title="<?php echo e(trans('messages.invoice')); ?>" ></i></a></li> -->
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