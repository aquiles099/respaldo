<?php
use App\Models\Admin\User;
$user = User::find(Session::get('key-sesion')['data']->id);
 ?>
<?php if(isset($user) && !is_null(Session::get('key-sesion')) && (Session::get('key-sesion')['type'] == \App\Helpers\HUserType::NATURAL_PERSON)): ?>
<!--paquetes-->
  <li >
    <a href="<?php echo e(asset('/account')); ?>" id="drdusr">
      <i class="fa fa-cubes"></i>
      <?php echo e(strtoupper(trans('messages.packages'))); ?>

        <?php if((isset($packages) && $packages->count() > 0) || (isset($filter) && isset($packages) && $packages->count() > 0)): ?>
            <sup style="background-color:#ed9028;" class="badge"><?php echo e(isset($packages_user)&&(($user->view==1)) ? $packages_user->count() : ($user->view!=1) ? $packages->count() : ''); ?></sup>
            <?php if($user->view!=1): ?>
              <?php
                  if ($user->view!=1) {
                    $user->view =1;
                    $user->save();
                  }
               ?>
            <?php endif; ?>
        <?php endif; ?>
    </a>
  </li>

  <?php /*
    <!--map direccion-->
     <li>
       <a href="<?php echo e(asset('/account/address')); ?>" id ="drdusr"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo e(strtoupper(trans('messages.icsadress'))); ?></a>
     </li>
    */ ?>
  <!--prealerta-->
  <li>
    <a href="<?php echo e(asset('/account/prealert')); ?>" id ="drdusr"><i class="fa fa-flag"></i> <?php echo e(strtoupper(trans('messages.prealert'))); ?></a>
  </li>
  <!--notificaciones-->
  <li class="dropdown" >
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id ="drdusr"><i class="fa fa-bell"></i>
      <?php echo e(strtoupper(trans('messages.notifications'))); ?>

      <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user" >
      <li class="dropdown-header"><?php echo e(trans('messages.options')); ?></li>
      <li class="divider"></li>
      <li>
        <a href="<?php echo e(asset('/account/notifications/settings')); ?>">
          <i class="fa fa-cog fa-fw" aria-hidden="true"></i> <?php echo e(trans('messages.manage')); ?>

        </a>
      </li>
    </ul>
  </li>
<?php endif; ?>
<li  id="step4" class="dropdown" >
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="drdusr">
        <i class="fa fa-user fa-fw"></i>
        <?php if(!is_null(Session::get('key-sesion')) && (Session::get('key-sesion')['type'] == \App\Helpers\HUserType::NATURAL_PERSON)): ?>
         <?php echo e(strtoupper(Session::get('key-sesion')['data']->name)); ?> <?php echo e(strtoupper(Session::get('key-sesion')['data']->last_name)); ?> | <i class="fa fa-qrcode" aria-hidden="true"></i> <?php echo e(Session::get('key-sesion')['data']->code); ?>

        <?php else: ?>
        <?php echo e(Session::get('key-sesion')['data']->code); ?> <?php echo e(Session::get('key-sesion')['data']->username); ?>

        <?php endif; ?>
        &nbsp;<i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
      <li class="dropdown-header"><?php echo e(trans('messages.options')); ?></li>
      <li class="divider"></li>
      <?php if(isset($user) && !is_null(Session::get('key-sesion')) && (Session::get('key-sesion')['type'] == \App\Helpers\HUserType::NATURAL_PERSON)): ?>
      <!---->
        <li>
          <a href="<?php echo e(asset('/account/user')); ?>">
            <i class="fa fa-user fa-fw" aria-hidden="true"></i> <?php echo e(trans('messages.myAccount')); ?>

          </a>
        </li>
      <!---->
        <li>
          <a href="<?php echo e(asset('/account/user/pass')); ?>">
            <i class="fa fa-lock" style="text-align:left" aria-hidden="true"></i> <?php echo e(trans('messages.changepassword')); ?>

          </a>
        </li>
      <?php endif; ?>
      <li><a href="<?php echo e(asset('/logout')); ?>"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> <?php echo e(trans('messages.logout')); ?></a></li>
    </ul>
</li>
