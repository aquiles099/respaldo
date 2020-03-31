<div <?php if(isset($error)): ?> class="active collapse in" aria-expanded="true" <?php endif; ?> class="collapse" id="section">
  <div class="well">
    <form class="" action="<?php echo e(asset($path)); ?>" method="post">
        <fieldset role="form">
          <div class="row">
            <div class="col-lg-5">
              <!--since_date-->
              <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'since_date'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="">
                <div class="col-lg-3">
                  <label for="value"><?php echo e(trans('messages.since_date')); ?></label>
                </div>
                <div class="col-lg-9">
                  	<div class="input-group">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.since_date')); ?>" id="since_date" name="since_date" type="text"  required="true" value="<?php echo e(clear(Input::get('since_date'))); ?>" >
                      <span class = "input-group-addon">
          							<i aria-hidden="true" class="fa fa-calendar"></i>
          						</span>
                    </div>
                      <?php echo $__env->make('errors.field', ['field' => 'since_date'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'until_date'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="">
                <div class="col-lg-3">
                  <label for="value"><?php echo e(trans('messages.until_date')); ?></label>
                </div>
                <div class="col-lg-9">
                  	<div class="input-group">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.until_date')); ?>" id="until_date" name="until_date" type="text"  required="true" value="<?php echo e(clear(Input::get('since_date'))); ?>" >
                      <span class = "input-group-addon">
          							<i aria-hidden="true" class="fa fa-calendar"></i>
          						</span>
                    </div>
                      <?php echo $__env->make('errors.field', ['field' => 'until_date'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
              </div>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-default btn-sm" style="width:100%">
                    <i aria-hidden="true" class="fa fa-search"></i>
                  <?php echo e(trans('messages.search')); ?>

                </button>
            </div>
          </div>
        </fieldset>
    </form>
  </div>
</div>
