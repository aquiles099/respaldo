<?php $js =  ['js/includes/userCtrl.js']; ?>
<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('user.list')); ?>
<?php $__env->startSection('title', trans('user.list')); ?>

<?php $__env->startSection('pre-title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title-actions'); ?>
<a href="<?php echo e(asset('admin/user/new')); ?>" onclick="loadButton(this)" class="btn btn-primary" title="<?php echo e(trans('company.create')); ?>">
  <i class="fa fa-plus" aria-hidden="true"></i>
  <?php echo e(trans('messages.create')); ?>

</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('pages.admin.user.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped" id="dtble">
        <thead>
          <tr>
            <th><?php echo e(trans('messages.code')); ?></th>
            <th><?php echo e(trans('messages.name')); ?></th>
            <th><?php echo e(trans('messages.email')); ?></th>
            <th><?php echo e(trans('messages.actions')); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($users as $row): ?>
            <tr item="<?php echo e($row->toInnerJson()); ?>">
              <td><a class="infoRd" href="javascript:details(<?php echo e($row->id); ?>)"><?php echo e($row->code); ?></a></td>
              <td style="text-transform:capitalize;"><center><?php echo e($row->name.' '.$row->last_name); ?></center></td>
              <td><center><?php echo e($row->email); ?></center></td>
              <td>
                <ul class="table-actions">
                  <center>
                    <li  onclick="userDelete($(this))"><a ><i class="fa fa-trash"  title="<?php echo e(trans('messages.delete')); ?>"></i></a></li>
                  </center>
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