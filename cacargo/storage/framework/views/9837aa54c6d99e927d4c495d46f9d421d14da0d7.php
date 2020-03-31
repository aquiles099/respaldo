<form onsubmit="createLoad()" role="form" action="<?php echo e(asset($path)); ?>" method="post">
  <?php if(isset($user)): ?>
    <input type="hidden" name="_method" value="patch">
  <?php endif; ?>
  <fieldset class="form">
    <!--name-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('user.name')); ?></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('user.name')); ?>" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="<?php echo e(isset($user) ? $user->name : Input::get('name')); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--apellidos-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'last_name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.last_name')); ?></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('messages.last_name')); ?>" name="last_name" type="text" autofocus maxlength="100" min="5" required="true" value="<?php echo e(isset($user) ? $user->last_name : Input::get('last_name')); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'last_name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--dni-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'dni'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.dni')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(strtoupper(trans('messages.indentToolTipText'))); ?>"></i></span></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('messages.dni')); ?>" name="dni" type="text" autofocus maxlength="100" min="5" required="true" value="<?php echo e(isset($user) ? $user->dni : Input::get('dni')); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'dni'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--sex-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'sex'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.sex')); ?></label>
      <div class="col-lg-9">
        <?php if(!isset($readonly) || $readonly == false): ?>
        <select class="form-control" name="sex" type="text"  required="true" id="ics_select_sex" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
          <option><?php echo e(trans('messages.optionSelect')); ?></option>
          <?php foreach($sex_user as $key => $value): ?>
            <option <?php echo e(isset($user) && $user->sex == $value['id'] ? 'selected' : Input::get('sex')); ?> value="<?php echo e($value['id']); ?>"><?php echo e($value['text']); ?></option>
          <?php endforeach; ?>
        </select>
        <?php else: ?>
        <input class="form-control" placeholder="<?php echo e(trans('messages.sex')); ?>" name="sex" type="text" value="<?php if(isset($user) && $user->sex == 'm'): ?> <?php echo e(trans('messages.male')); ?> <?php elseif($user->sex == 'f'): ?> <?php echo e(trans('messages.female')); ?> <?php else: ?> <?php echo e(trans('prealert.unknown')); ?> <?php endif; ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php endif; ?>
        <?php echo $__env->make('errors.field', ['field' => 'sex'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
     </div>
    </div>
    <!--local_phone-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'local_phone'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.local_phone')); ?></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('messages.local_phone')); ?>" name="local_phone" type="text" autofocus maxlength="100" min="5" value="<?php echo e(isset($user) ? $user->local_phone : Input::get('local_phone')); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'local_phone'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--celular-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'celular'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.celular')); ?></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('messages.celular')); ?>" name="celular" type="text" autofocus maxlength="100" min="5" value="<?php echo e(isset($user) ? $user->celular : Input::get('celular')); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'celular'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--country-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'country'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.country')); ?></label>
      <div class="col-lg-9">
        <?php if(!isset($readonly) || $readonly == false): ?>
        <select class="form-control" name="country" placeholder="<?php echo e(trans('messages.country')); ?>" required="true"  id="ics_select_country_register">
          <option><?php echo e(trans('messages.optionSelect')); ?></option>
          <?php if(isset($countrys)): ?>
            <?php foreach($countrys as $country): ?>
              <option <?php echo e(isset($user) && $user->country == $country ? 'selected' : Input::get('country')); ?> value="<?php echo e($country); ?>"><?php echo e($country); ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
        <?php else: ?>
        <input class="form-control" placeholder="<?php echo e(trans('messages.country')); ?>" name="country" type="text" value="<?php echo e(isset($user) ? $user->country : Input::get('country')); ?>"  required="true" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php endif; ?>
        <?php echo $__env->make('errors.field', ['field' => 'country'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--region-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'region'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.region')); ?></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('messages.region')); ?>" name="region" type="text" value="<?php echo e(isset($user) ? $user->region : Input::get('region')); ?>"  <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'region'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--address-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'address'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.address')); ?></label>
      <div class="col-lg-9">
        <textarea class="form-control" name="address" id="address" placeholder="<?php echo e(trans('messages.address')); ?>"  <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>><?php echo e(isset($user) ? $user->address : Input::get('address')); ?></textarea>
        <?php echo $__env->make('errors.field', ['field' => 'address'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--city-->
    <div class="form-group row  <?php echo $__env->make('errors.field-class', ['field' => 'city'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.city')); ?></label>
      <div class="col-lg-9">
        <input type="text" class="form-control" name="city" id="city" placeholder="<?php echo e(trans('messages.city')); ?>" value="<?php echo e(isset($user) ? $user->city : Input::get('city')); ?>"  <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'city'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--postal_code-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'postal_code'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('messages.postal_code')); ?></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('messages.postal_code')); ?>" name="postal_code" type="text" value="<?php echo e(isset($user) ? $user->postal_code : Input::get('postal_code')); ?>"  <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'postal_code'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--email-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('user.email')); ?></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('user.email')); ?>" name="email" type="email" maxlength="50" min="5" required="true" value="<?php echo e(isset($user) ? $user->email : Input::get('email')); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--password-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('user.password')); ?></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('user.password')); ?>" name="password" type="password" maxlength="25" min="5" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--repassword-->
    <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <label class="col-lg-3 control-label"><?php echo e(trans('user.repassword')); ?></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="<?php echo e(trans('user.repassword')); ?>" name="password_confirmation" type="password" maxlength="25" min="5" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
        <?php echo $__env->make('errors.field', ['field' => 'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    <?php if(!isset($readonly) || !$readonly): ?>
      <div class="col-lg-12 buttons" id="divButton">
        <div class="pull-left text-muted"></div>
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          <?php echo e(trans(isset($user)?'messages.update' : 'messages.save')); ?>

        </button>
      </div>
    <?php endif; ?>
  </fieldset>
</form>
