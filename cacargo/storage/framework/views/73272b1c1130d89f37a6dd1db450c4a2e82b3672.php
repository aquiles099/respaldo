<div class="panel panel-default" id="" >
  <div class="panel-body">
    <table class="" id="dtble">
      <thead>
        <tr>
          <th style="width:10%; text-align:center;"><?php echo e(trans('package.tracking')); ?></th>
          <th style="width:50%; text-align:center;"><?php echo e(trans('package.type')); ?></th>
          <th style="width:25%; text-align:center;"><?php echo e(trans('package.invoice')); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($packages as $package): ?>
        <tr item="">
          <td><a class="infoRd" href="javascript:detailspackagedash('<?php echo e($package->id); ?>')"><?php echo e($package->tracking); ?></a></td>
          <td><?php echo e($package->getType != null ? $package->getType->getName() : ''); ?></td>
          <td><?php if($package->invoice == 0): ?><i class="fa fa-times" aria-hidden="true"></i><?php else: ?><i class="fa fa-check" aria-hidden="true"></i><?php endif; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
