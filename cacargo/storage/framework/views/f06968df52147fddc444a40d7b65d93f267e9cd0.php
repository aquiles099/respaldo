    <?php if(!isset($noFooter)): ?>
    <footer class="footer panel-white">
      <div class="container text-muted">
        <span class="">
            <?php echo e(trans('messages.devBy')); ?>:
        </span>
        <span>
          <a href="http://solidprojectsolutions.com/index.php/es/home-page/" target="blank"><img src="<?php echo e(asset('/dist/images/logoSps.png')); ?>" width="160"></a>
        </span>
        <span class="pull-right" style="padding-top: 10px">
           <?php echo e(trans('messages.infoApp')); ?>

        </span>
      </div>
    </footer>
    <?php endif; ?>
    <?php
      global $picks;
    ?>
    <!-- jQuery -->
    <script src="<?php echo e(asset('bower_components/jquery/dist/jquery.min.js')); ?>"></script>
    <!-- jQuery UI -->
    <script src="<?php echo e(asset('libs/jquery-ui.js')); ?>"></script>
    <!--DataTables-->
    <script src="<?php echo e(asset('libs/dataTables.min.js')); ?>"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo e(asset('bower_components/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo e(asset('bower_components/metisMenu/dist/metisMenu.min.js')); ?>"></script>
    <!-- jquery-editable-select -->
    <!-- <script src="<?php echo e(asset('bower_components/jquery-editable-select/dist/jquery-editable-select.min.js')); ?> "></script>-->
    <script src="<?php echo e(asset('bower_components/jquery-editable-select/dist/jquery-editable-select.js')); ?> "></script>
    <!-- select2 -->
    <script src="<?php echo e(asset('js/select2/js/select2.min.js')); ?>"></script>
    <!--Bootbox -->
    <script src="<?php echo e(asset('js/bootbox.min.js')); ?>"></script>
    <script>
      bootbox.setDefaults({
        locale: "<?php echo e(Config::get('app.locale')); ?>",
        className: "bootbox"
      });
    </script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo e(asset('dist/js/sb-admin-2.js')); ?>"></script>
    <script src="<?php echo e(asset('js/validator.min.js')); ?>"></script>
    <!--Custom dropzone-->
    <script src="<?php echo e(asset('bower_components/dropzone/dist/min/dropzone.min.js')); ?>"></script>
    <?php echo $__env->yieldContent('footer'); ?>
    <script>
      (function($) {
        <?php echo $__env->make('sections.list.picks', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->yieldContent('onready'); ?>
      }(jQuery));
    </script>
  </body>
</html>
