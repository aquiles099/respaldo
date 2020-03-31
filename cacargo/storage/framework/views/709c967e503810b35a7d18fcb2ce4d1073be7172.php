<?php echo $__env->make('sections.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php
use App\Models\Admin\Configuration;
    /**
    * Se asigna logo al sistema
    */
    $logo = Configuration::all()->last();
    $configuration = Configuration::find(1);
    if ($configuration->time_zone == null) {
      $configuration->time_zone = 'America/Caracas (UTC-04:30)';
      $configuration->save();
    }
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $lang = isset($configuration->language) ? $configuration->language : 'en';
      App::setLocale($lang);
    /**
    *
    */
?>
<script src="<?php echo e(asset('js/includes/trialCrtl.js')); ?>"></script>
<script type="text/javascript">
    var messages = {
      language : "<?php echo $lang; ?>"
    };

    setInterval( function (){
      var url      = asset('admin/configuration') +'/hour';
      $('a#step4').removeClass('active');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            beforeSend: function ()
            {

            },
            success: function (json)
            {
              if (json.message == 'true') {
                  $('#timezone').html('Fecha y hora del sistema: '+json.time);
              }else {
                $('#timezone').html('');
              }
            }
          });
    }, 1000 );
</script>
<div id="wrapper"  style="background-color:white">
  <nav id="navbar" class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo e(asset('/')); ?>"><img class = "headerlogo" src="<?php echo e(isset($logo) ? ($logo->logo_ics == '') ? asset('/uploads/logo/005.png') : $logo->logo_ics : asset('/uploads/logo/005.png')); ?>"/></a>
    </div>
    <div class="navbar-header">
      <br>
      <?php
        use App\Models\Admin\User;
        if (isset(Session::get('key-sesion')['data']->id)) {
          $sesion = Session::get('key-sesion')['data']->profile;
          if ($sesion==null) {
            $user = User::find(Session::get('key-sesion')['data']->id);
          }
        }
       ?>
       <?php if(isset($user->code)): ?>
          <p>

            <?php echo e($user->code); ?> <?php echo e(ucwords($user->name)); ?> <?php echo e(ucwords($user->last_name)); ?><br>
            3750 NW 114 Ave Unit 2 <br>
            Miami, FL 33178 <br>
            Phone: (786) 360-4291
          </p>
        <?php endif; ?>
    </div>
    <div id="timezone" class="" value="" style="margin-top:2px;color:gray;padding-left:79%;height:0px;">
    </div>
    <?php if(!isset($user) || isset($toolbar)): ?>
      <ul class="nav navbar-top-links navbar-right">
        <?php $__env->startSection('toolbar-custom-pre'); ?>
          <?php if(!is_null(Session::get('key-sesion'))): ?>
            <?php if(!isset($user)): ?>
            <li id="step1">
              <a href="<?php echo e(asset('/')); ?>" id ="drdusr"><i class="fa fa-home"></i> <?php echo e(trans('messages.home')); ?></a>
            </li>
            <li id="step2">
              <a href="<?php echo e(asset('/admin/configuration')); ?>" id ="drdusr"><i class="fa fa-cog"></i> <?php echo e(strtoupper(trans('menu.adjustments'))); ?></a>
            </li>
            <li id="step3" class="dropdown" >
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id ="drdusr"><i class="fa fa-support"></i>
                <?php echo e(trans('menu.help')); ?>

                <i class="fa fa-caret-down"></i>
              </a>
              <ul class="dropdown-menu dropdown-user" style="right: -47px;">
                <li>
                  <a href="<?php echo e(asset('/admin/incidence/new')); ?>">
                    <i class="fa fa-bullhorn"></i> <?php echo e(trans('menu.incidence')); ?>

                  </a>
                </li>
                <li style="cursor: pointer;" onclick="javascript:acercaDe()">
                    <div class="" style="margin-left:20px;">
                      <i class="fa fa-info-circle"></i><?php echo e(trans('menu.about')); ?>

                    </div>
                </li>
              </ul>
            </li>
              <?php echo $__env->make('sections.toolbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <!--<li style="cursor: pointer;"id="tuto">
                <i class="fa fa-info-circle"></i> Tutorial
              </li>-->
            <?php else: ?>
              <?php echo $__env->make('sections.toolbar.user', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
          <?php endif; ?>
        <?php echo $__env->yieldSection(); ?>
        <?php echo $__env->yieldContent('toolbar-custom-post'); ?>
      </ul>
    <?php endif; ?>
    <?php if(!isset($menu) && !isset($only)): ?>
      <?php echo $__env->make('sections.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
  </nav>
  <div id="page-wrapper" class="<?php echo e(isset($only) ? 'only' : ''); ?>">
    <div class="container-fluid <?php echo e(isset($pageCSS) ? $pageCSS : ''); ?>">
      <?php echo $__env->yieldContent('pre-title'); ?>
      <?php if(!isset($noTitle)): ?>
        <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header" style="color:#23527c">
                <?php echo $__env->yieldContent('icon-title'); ?>
                <?php echo $__env->yieldContent('title', 'Document Title'); ?> <span id="rowLoad" style="font-size: 25px"><small><i class='fa fa-spin fa-spinner'></i> <?php echo e(trans('configuration.rowLoad')); ?></small></span>
                <div class="pull-right"><?php echo $__env->yieldContent('title-actions'); ?></div>
              </h1>
          </div>
        </div>
      <?php endif; ?>
      <div class="row" >
        <div class="col-lg-12">
          <?php $__env->startSection('body'); ?>
              Document body...
          <?php echo $__env->yieldSection(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $__env->make('sections.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
