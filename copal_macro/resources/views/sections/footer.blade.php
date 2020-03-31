    @if(!isset($noFooter))
    <footer class="footer panel-white">
      <div class="container text-muted">
        <span class="">
            {{trans('messages.devBy')}}:
        </span>
        <span>
          <a href="http://solidprojectsolutions.com/index.php/es/home-page/" target="blank"><img src="{{asset('/dist/images/logoSps.png')}}" width="160"></a>
        </span>
        <span class="pull-right" style="padding-top: 10px">
           {{trans('messages.infoApp')}}
        </span>
      </div>
    </footer>
    @endif
    <?php
      global $picks;
    ?>
    <!-- jQuery -->
    <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('libs/jquery-ui.js')}}"></script>
    <!--DataTables-->
    <script src="{{asset('libs/dataTables.min.js')}}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>
    <!-- jquery-editable-select -->
    <!-- <script src="{{asset('bower_components/jquery-editable-select/dist/jquery-editable-select.min.js')}} "></script>-->
    <script src="{{asset('bower_components/jquery-editable-select/dist/jquery-editable-select.js')}} "></script>
    <!-- select2 -->
    <script src="{{asset('js/select2/js/select2.min.js')}}"></script>

    <script src="{{asset('libs/moment.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap-datetimepicker.min.js')}}"></script>
    <!--Bootbox -->
    <script src="{{asset('js/bootbox.min.js')}}"></script>
    <script>
      bootbox.setDefaults({
        locale: "{{Config::get('app.locale')}}",
        className: "bootbox"
      });
    </script>
    <!-- Custom Theme JavaScript -->
    <script src="{{asset('dist/js/sb-admin-2.js')}}"></script>
    <script src="{{asset('js/validator.min.js')}}"></script>
    <!--Custom dropzone-->
    <script src="{{asset('bower_components/dropzone/dist/min/dropzone.min.js')}}"></script>
    @yield('footer')
    <script>
      (function($) {
        @include('sections.list.picks')
        @yield('onready')
      }(jQuery));
    </script>
  </body>
</html>
