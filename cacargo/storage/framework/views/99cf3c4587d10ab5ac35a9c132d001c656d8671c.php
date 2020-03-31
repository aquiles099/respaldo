<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="row">
	<div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b><?php echo e(trans('package.code')); ?>:</b></td>
              <td><?php echo e(isset($package) ? $package->code : Input::get('code')); ?></td>
            </tr>
            <tr>
              <tr>
              <td><b><?php echo e(trans('package.tracking')); ?>:</b></td>
              <td><?php echo e(isset($package->tracking) ? $package->tracking : Input::get('code')); ?></td>
            </tr>
            <tr>
              <td><b><?php echo e(trans('package.from')); ?>:</b></td>
              <td><?php echo e(isset($package) ? (isset($package->to_client) ? $company->name : $package->getCourier['name']) : ''); ?></td>
            </tr>
            <tr>
              <td><b><?php echo e(trans('package.to')); ?>:</b></td>
              <td><?php echo e(isset($package) ? (isset($package->to_client) ?  $package->getToClient['code']."-".$package->getToClient['name'] : $package->getToUser['code']."-".$package->getToUser['name']." ".$package->getToUser['last_name']) : ''); ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!--Segundo cuadro, se muestra tipo, categoria y estado -->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b><?php echo e(trans('package.type')); ?>:</b></td>
              <td><?php echo e(isset($package) ? $package->getType['spanish'] : Input::get('type')); ?></td>
            </tr>
            <!-- <tr>
              <td><b><?php echo e(trans('package.category')); ?>:</b></td>
              <td><?php echo e(isset($package) ? $package->getCategory['label'] : Input::get('category')); ?></td>
            </tr> -->
            <tr>
              <td><b><?php echo e(trans('package.status')); ?>:</b></td>
              <td><?php echo e(isset($package) ? $package->getLastEvent['description'] : Input::get('last_event')); ?></td>
            </tr>
             <tr>
              <td><b><?php echo e(trans('package.receipt')); ?>:</b></td>
              <td><?php echo e(isset($receipt) ? $receipt->code : Input::get('last_event')); ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

</div>

<div class="row">
	<div class="col-md-6">
	 	<div class="panel panel-default" style="margin-bottom: 0px;">
	 	 	<div class="panel-heading">
	          	<h3 class="text-center" id="clientTitle" style="display:block;text-decoration: underline;">
	          		<?php echo e(trans('messages.description_pack')); ?>

	          	</h3>
        	</div>
	    	<div class="panel-body" style="padding: 2px;background-color:#eee">
	       		<div class="col-md-12" style="padding: 20px;" >
	       			<p><?php echo e(trans('messages.tracking')); ?>:<strong><?php echo e(isset($package) ? $package->code : Input::get('code')); ?></strong></p>
              <p><?php echo e(trans('messages.value')); ?>: <strong><?php echo e(isset($package) ? $package->value : Input::get('value')); ?> $.</strong> </p>
              <p><?php echo e(trans('package.volumetricweight')); ?>:<strong>

                <?php if(isset($package->type) && ($package->type==1)): ?>
                   <?php echo e($package->volumetricweightm.' ft3'); ?>

                <?php elseif(isset($package->type) && ($package->type==2)): ?>
                    <?php echo e($package->volumetricweighta."vlb"); ?>

                <?php endif; ?>


               </strong></p>
              <p><?php echo e(trans('messages.large')); ?>: <strong><?php echo e(isset($package) ? $package->large : Input::get('large')); ?> in</strong></p>
	       			<p ><?php echo e(trans('messages.width')); ?>: <strong><?php echo e(isset($package) ? $package->width : Input::get('width')); ?> in</strong></p>
              <p><?php echo e(trans('messages.height')); ?>: <strong><?php echo e(isset($package) ? $package->height : Input::get('height')); ?> in</strong></p>
              <p><?php echo e(trans('messages.weight')); ?>: <strong><?php echo e(isset($package) ? $package->weight : Input::get('weight')); ?> lb.</strong> </p>


	       		</div>

	 		</div>
	 	</div>
 	</div>


	<div class="col-md-6">
      <div class="panel panel-default" style="margin-bottom: 0px;">
      <div class="panel-heading">
              <h3 class="text-center" id="clientTitle" style="display:block;text-decoration: underline;">
                <?php echo e(trans('messages.receipt_detail')); ?>

              </h3>
          </div>
    <div class="panel-body" style="padding: 2px;background-color:#eee">

    <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p><?php echo e(trans('package.service')); ?>:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p><?php echo e(isset($detailtype->value_package) ? $detailtype->value_package :'0'); ?>$</p>
    </div>

    <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p><?php echo e(trans('package.insurance')); ?>:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p><?php echo e(isset($insurance->value_package) ? $insurance->value_package :'0'); ?>$</p>
    </div>

     <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p><?php echo e(trans('package.addcharge')); ?>:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p>-<?php echo e(isset($addcharge->value_package) ? $addcharge->value_package :'0'); ?>$</p>
    </div>


     <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p style="font-weight: bold;">Subtotal:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p style="font-weight: bold;"><?php echo e($receipt->subtotal); ?>$</p>
    </div>

    <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <?php if(isset($detailsreceipt)): ?>
                <?php foreach($detailsreceipt as $row): ?>
                   <p> Tax (<?php echo e($row->value_oring); ?>%)</p>
                   <?php endforeach; ?>
              <?php endif; ?>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <?php if(isset($detailsreceipt)): ?>
                <?php foreach($detailsreceipt as $row): ?>
                   <p> +<?php echo e($row->value_package); ?></p>
                   <?php endforeach; ?>
              <?php endif; ?>
    </div>

    <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p><?php echo e(trans('package.promotion')); ?>:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p>-<?php echo e(isset($promo->value_package) ? $promo->value_package :'0'); ?>$</p>
    </div>

    <div class="col-md-12">
    <div class="panel panel-default">

        <div class="panel-body" style="padding: 4px;background-color:#f5f5f5">
            <div class="col-md-8" ><h4 style="text-align: right;font-weight: 900;">Total</h4></div>
            <div class="col-md-4">
              <?php if(isset($receipt)): ?>
                <h4 style="text-align: left;font-weight: 900;"><?php echo e($receipt->total); ?>$</h4>
          <?php endif; ?>
            </div>
      </div>
    </div>
  </div>
	</div>
  </div>




</div>
