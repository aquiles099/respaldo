<?php $buttonPadding =  20; ?>
<?php $user = 'user'; ?>
<?php $toolbar = 'toolbar'; ?>
<?php $only = 'only'; ?>
<?php $noTitle = 'noTitle'; ?>

<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('messages.userRegister')); ?>
<?php $__env->startSection('title', trans('messages.register')); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('toolbar-custom-pre'); ?>
  <li><a href="<?php echo e(asset('/login')); ?>" id ="drdusr"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo e(trans('messages.logIn')); ?></a></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="login-panel panel panel-default shadow" style="margin-top:0px">
      <div class="panel-heading text-center">
        <span class="text-muted"><i class="fa fa-user" aria-hidden="true"></i> <?php echo e(trans('messages.signIn')); ?></span>
      </div>
      <div class="panel-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <form onsubmit="submitForm()" role="form" id="registerForm" method="post" data-toggle="validator">
              <?php echo e(csrf_field()); ?>

              <fieldset>
                <!--name-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.name')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.name')); ?>" name="name" type="text" value="<?php echo e(Input::get('name')); ?>" required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--last_name-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'last_name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                 <label class="col-lg-3 control-label"><?php echo e(trans('messages.last_name')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.last_name')); ?>" name="last_name" type="text" value="<?php echo e(Input::get('last_name')); ?>"  required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'last_name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                 </div>
                </div>
                <!--dni-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'dni'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.dni')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.dni')); ?>" name="dni" type="text" value="<?php echo e(Input::get('dni')); ?>"  required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'dni'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                 </div>
                </div>
                <!--sex-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'sex'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.sex')); ?></label>
                  <div class="col-lg-9">
                    <select class="form-control" name="sex" type="text"  required="true" id="ics_select_sex">
                      <option><?php echo e(trans('messages.optionSelect')); ?></option>
                      <?php foreach($sex_user as $key => $value): ?>
                        <option <?php echo e((Input::get('sex')) == $value['id'] ? 'selected' : ''); ?> value="<?php echo e($value['id']); ?>"><?php echo e($value['text']); ?></option>
                      <?php endforeach; ?>
                    </select>
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'sex'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                 </div>
                </div>
                <!--country-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'country'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.country')); ?></label>
                  <div class="col-lg-9">
                    <select class="form-control" name="country" placeholder="<?php echo e(trans('messages.country')); ?>" required="true" value="<?php echo e(Input::get('country')); ?>" id="ics_select_country_register">
                      <option value=""><?php echo e(trans('messages.optionSelect')); ?></option>
                      <?php if(isset($countrys)): ?>
                        <?php foreach($countrys as $country): ?>
                          <option <?php echo e((Input::get('country')) == $country ? 'selected' : ''); ?> value="<?php echo e($country); ?>"><?php echo e($country); ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'country'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--region-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'region'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.region')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.region')); ?>" name="region" type="text" value="<?php echo e(Input::get('region')); ?>"  required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'region'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--address-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'address'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.address')); ?></label>
                  <div class="col-lg-9">
                    <textarea class="form-control" name="address" id="address" required="true" placeholder="<?php echo e(trans('messages.address')); ?>" value="<?php echo e(Input::get('address')); ?>" required="true"><?php echo e(Input::get('address')); ?></textarea>
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'address'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--city-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'city'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.city')); ?></label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="city" id="city" required="true" placeholder="<?php echo e(trans('messages.city')); ?>" value="<?php echo e(Input::get('city')); ?>" required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'city'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--postal_code-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'postal_code'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.postal_code')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.postal_code')); ?>" name="postal_code" type="text" value="<?php echo e(Input::get('postal_code')); ?>"  required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'postal_code'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--local_phone-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'local_phone'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.local_phone')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.local_phone')); ?>" name="local_phone" type="text" value="<?php echo e(Input::get('local_phone')); ?>"  required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'local_phone'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--celular-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'celular'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.celular')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.celular')); ?>" name="celular" type="text" value="<?php echo e(Input::get('celular')); ?>"  required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'celular'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--email-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.email')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.email')); ?>" name="email" type="email" required value="<?php echo e(Input::get('email')); ?>" required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--password-->
                <div class="form-group <?php echo $__env->make('errors.field-class', ['field' => 'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.password')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.password')); ?>" name="password" type="password" id="password" data-minlength="8"  required="true">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--password_confirmation-->
                <div class="form-group  <?php echo $__env->make('errors.field-class', ['field' => 'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label"><?php echo e(trans('messages.password')); ?>*</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="<?php echo e(trans('messages.repassword')); ?>" name="password_confirmation" type="password" data-match="#password"  <?php if(!isset($user)): ?>required="true"<?php endif; ?>>
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'password_confirmation'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--accept-->
                <div class="css-right">
                  <a href="<?php echo e(asset('/terms')); ?>" target="blank" class="btn btn-xs"><?php echo e(trans('messages.terms')); ?></a>
                    <span class="text-muted"><input name="accept" type="checkbox" id="check" value="1" onclick="disableElement()"> <label for="check"><?php echo e(trans('messages.confirmTerms')); ?></label> </span>
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'accept'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <!-- Change this to a button or input when using this as a form -->
                <div class="pull-left text-muted" id="loadRecover"></div>
                <button type="submit" class="btn btn-primary pull-right" id="submitBnt" disabled=disabled><?php echo e(trans('messages.send')); ?></button>
                <a href="<?php echo e(asset('/help')); ?>" target="blank" class="btn pull-right" style="margin-right:10px"><?php echo e(trans('messages.help')); ?></a>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>