<?php $js =  ['js/includes/countryCtrl.js']; ?>
<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('country.countries')); ?>
<?php $__env->startSection('title', trans('country.countries')); ?>

<?php $__env->startSection('pre-title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title-actions'); ?>
<a href="<?php echo e(asset('admin/country/new')); ?>" onclick="loadButton(this)" class="btn btn-primary" title="<?php echo e(trans('country.create')); ?>">
  <i class="fa fa-plus" aria-hidden="true"></i>
  <?php echo e(trans('messages.create')); ?>

</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('pages.admin.country.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="panel panel-default" id = "pnlin">
  <div class="panel-body">
    <table class="table table-striped table-hover" id="dtble">
      <thead>
        <tr>
          <th><?php echo e(trans('messages.code')); ?></th>
          <th><?php echo e(trans('messages.name')); ?></th>
          <th><?php echo e(trans('messages.actions')); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($countrys as $row): ?>
          <tr item="<?php echo e($row->toInnerJson()); ?>">
            <td><a class = "infoRd" href = "javascript:details(<?php echo e($row->id); ?>)"><?php echo e($row->code); ?></a></td>
            <td style="text-transform:capitalize;"><?php echo e($row->name); ?></td>
            <td>
              <ul class="table-actions">
                <li><a onclick="countryDelete($(this))" ><i class="fa fa-trash"  title="<?php echo e(trans('messages.delete')); ?>"></i></a></li>
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