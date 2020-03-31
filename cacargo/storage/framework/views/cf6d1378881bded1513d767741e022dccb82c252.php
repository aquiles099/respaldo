<?php
if(isset($package) && !is_null($package->getLastEvent)) {
  $position = $package->getLastEvent->step;
}
else {
  $position = -1;
}
?>
<?php $only = 'only'; ?>
<?php
use App\Helpers\HUserType;
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
<?php $__env->startSection('pageTitle', trans('messages.account')); ?>
<?php $js = ['js/includes/resellerCtrl.js']; ?>
<?php $__env->startSection('icon-title'); ?>
  <i aria-hidden="true" class="fa fa-user"></i>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title', trans('messages.myAccount')); ?>

<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('title-actions'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
  <?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="panel panel-default" id="pnlin">
  <div class="panel-heading">
    <div class="row">
      <?php /*
        <div class="col-md-1 col-lg-1 col-sm-1">
          <a href="javascript:icsViewPicProfile()">
            <img src="<?php echo e(asset('/dist/images/user.jpg')); ?>" style="height: 50px" data-toggle="tooltip" title="<?php echo e($user->name); ?> <?php echo e($user->last_name); ?>" class="img-responsive img-circle"/>
          </a>
        </div>
        */ ?>
      <div class="col-md-5 col-lg-5 col-sm-5 col-xs-5 text-center text-muted" style="margin-top: 15px">
        <?php echo e(trans('messages.created')); ?>: <?php echo e($user->created_at); ?>

      </div>
      <div class="col-md-5 col-lg-5 col-sm-5 col-xs-5 text-center text-muted" style="margin-top: 15px">
        <?php echo e(trans('messages.updated')); ?>: <?php echo e($user->updated_at); ?>

      </div>
    </div>
  </div>
  <div class="panel-body" >
    <form role="form" action="<?php echo e(asset($path)); ?>" onsubmit="updateUserLoad()" method="post" data-toggle="validator">
        <?php if(isset($user)): ?>
          <input type="hidden" name="_method" value="patch">
        <?php endif; ?>
        <div class="row">
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading text-center">
                <span class="text-muted">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  <?php echo e(trans('messages.personaldata')); ?>

                </span>
              </div>
              <div class="panel-body">
                <fieldset>
                  <!--name-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="content" id="label"><?php echo e(trans('messages.name')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.name')); ?>" name="name" type="text" autofocus value="<?php echo e($user->name); ?>" required="true">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--last_name-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'last_name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="content" id="label"><?php echo e(trans('messages.last_name')); ?></label>
                    <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.last_name')); ?>" name="last_name" type="text" value="<?php echo e($user->last_name); ?>"  required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'last_name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                   </div>
                  </div>
                  <!--dni-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'dni'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="content" id="label"><?php echo e(trans('messages.dni')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.dni')); ?>" name="dni" type="text" value="<?php echo e($user->dni); ?>"  required="true">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'dni'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--sex-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'sex'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label"><?php echo e(trans('messages.sex')); ?></label>
                    <div class="col-lg-9">
                      <select class="form-control" name="sex" type="text"  required="true" id="ics_select_sex">
                        <option><?php echo e(trans('messages.optionSelect')); ?></option>
                        <?php foreach($sex_user as $key => $value): ?>
                          <option <?php echo e(isset($user) && $user->sex == $value['id'] ? 'selected' : ''); ?> value="<?php echo e($value['id']); ?>"><?php echo e($value['text']); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'sex'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                   </div>
                  </div>
                  <!--celular-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'celular'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="content" id="label"><?php echo e(trans('messages.celular')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.celular')); ?>" name="celular" type="text" value="<?php echo e($user->celular); ?>"  required="true">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'celular'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--email-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="content" id="label"><?php echo e(trans('messages.email')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.email')); ?>" name="email" type="email" required value="<?php echo e($user->email); ?>" required="true" readonly=true>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--password-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="content" id="label">
                        <?php echo e(trans('messages.password')); ?>

                        <span class="pull-right">
                          <a class="infoRd" href="<?php echo e(asset('/account/user/pass')); ?>" data-toggle="tooltip" title="<?php echo e(trans('messages.changepassword')); ?>"><i aria-hidden="true" class="fa fa-refresh"></i></a>
                        </span>
                    </label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.password')); ?>" type="password"  data-minlength="8"  required="true" value="<?php echo e($user->password); ?>" readonly=true>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading text-center">
                  <span class="text-muted">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <?php echo e(trans('messages.billingdelivery')); ?>

                  </span>
              </div>
              <div class="panel-body" style="margin-bottom: 24px">
                <fieldset>
                  <!--country-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'country'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="country" id="label"><?php echo e(trans('messages.country')); ?></label>
                    <div class="col-lg-9">
                      <select class="form-control" id="country" name="country" required="true" >
                        <option><?php echo e(trans('messages.optionSelect')); ?></option>
                        <?php foreach($country as $key => $value): ?>
                          <option <?php echo e($user->country == $value ? 'selected':''); ?>><?php echo e($value); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'country'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--region-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'region'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="region" id="label"><?php echo e(trans('messages.region')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.region')); ?>" name="region" type="text" autofocus value="<?php echo e($user->region); ?>" required="true">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'region'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--city-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'city'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="region" id="label"><?php echo e(trans('messages.city')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.city')); ?>" name="city" type="text" autofocus value="<?php echo e($user->city); ?>" required="true">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'city'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--local_phone-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'local_phone'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="local_phone" id="label"><?php echo e(trans('messages.local_phone')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.local_phone')); ?>" name="local_phone" type="text" autofocus value="<?php echo e($user->local_phone); ?>" required="true">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'local_phone'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--local_phone-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'postal_code'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="postal_code" id="label"><?php echo e(trans('messages.postal_code')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.postal_code')); ?>" name="postal_code" type="text" autofocus value="<?php echo e($user->postal_code); ?>" required="true">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'postal_code'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--address-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'address'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="postal_code" id="label"><?php echo e(trans('messages.address')); ?></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" placeholder="<?php echo e(trans('messages.address')); ?>" name="address" value="<?php echo e($user->address); ?>" required="true" ><?php echo e($user->address); ?></textarea>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'address'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--Type of packages-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'type_packages'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="postal_code" id="label"><?php echo e(trans('messages.type_packages')); ?></label>
                    <div class="col-lg-9">
                      <select id="type_packages" class="form-control" name="type_packages">
                        <option <?php echo e(($user->type_packages == 0) ? 'selected': ''); ?> value="0"><?php echo e(trans('messages.optionSelect')); ?></option>
                        <option <?php echo e(($user->type_packages == '1') ? 'selected': ''); ?> value="1"><?php echo e(trans('messages.banca')); ?></option>
                        <option <?php echo e(($user->type_packages == 2) ? 'selected': ''); ?> value="2"><?php echo e(trans('messages.magazzine')); ?></option>
                        <option <?php echo e(($user->type_packages == 3) ? 'selected': ''); ?> value="3"><?php echo e(trans('messages.various')); ?></option>
                      </select>
                        <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'postal_code'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--Type of packages-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'postal_code'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="postal_code" id="label_specific"><?php echo e(trans('messages.specific_packages')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="<?php echo e(trans('messages.specific_packages')); ?>" id="specific_packages" name="specific_packages" type="text" autofocus value="<?php echo e($user->specific_packages); ?>">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'postal_code'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
        <!-- Change this to a button or input when using this as a form -->
        <div class="pull-right" style="padding-right: 2%">
            <span class="text-muted"><input type="checkbox" id="check" value="1" onclick="disableElement()" /> <label for="check"><?php echo e(trans('messages.confirmchange')); ?></label></span>
            <button type="submit" class="btn btn-primary" id="submitBnt" disabled=disabled><?php echo e(trans('messages.send')); ?></button>
        </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>