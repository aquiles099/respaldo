<section class="spacer icsbgfoot" style="background-color: #2b2b2b;">
	<div class="container">
		<div class="row">
      <div class="col-md-12">
        <footer>
          <div class="container text-muted">
            <span class="pull-left">
              {{trans('messages.devBy')}}
              <a href="{{env('ICS_SPS_URL')}}" target="blank"><img src="{{asset('/dist/img/logoSps.png')}}" width="200px"></a>
          	</span>
            <span class="pull-right" style="padding-top: 1%">
              {{trans('messages.infoApp')}}
            </span>
          </div>
        </footer>
        @if(is_null(Session::get('key-sesion')))
        <a href="#" class="scrollup"><i class="icon-angle-up icon-square icon-bgdark icon-2x icsbgfoot"></i></a>
        @endif
      </div>
    </div>
  </div>
</section>
  <!--Set Scrollto Js-->
  {!! HTML::script(asset('dist/js/jquery.scrollTo.js')) !!}
  <!--Set Datatables Js-->
  {!! HTML::script(asset('bower_components/datatables/media/js/jquery.dataTables.min.js')) !!}
  <!-- Set Select 2 -->
  {!! HTML::script(asset('bower_components/select2/dist/js/select2.min.js')) !!}
  <!--Set Jquery Nav Js-->
  {!! HTML::script(asset('dist/js/jquery.nav.js')) !!}
  <!--Set Bootstrap Js-->
  {!! HTML::script(asset('dist/js/bootstrap.js')) !!}
  <!--Set Bootbox Js-->
  {!! HTML::script(asset('bower_components/bootbox.js/bootbox.js')) !!}
  <!--Set localscroll Js-->
  {!! HTML::script(asset('dist/js/jquery.localscroll-1.2.7-min.js')) !!}
  <!--Set PrettyPhoto Js-->
  {!! HTML::script(asset('dist/js/jquery.prettyPhoto.js')) !!}
  <!--Set Isotope Js-->
  {!! HTML::script(asset('dist/js/isotope.js')) !!}
  <!--Set Flexslder Js-->
  {!! HTML::script(asset('dist/js/jquery.flexslider.js')) !!}
  <!--Set Owl-Carousel Js-->
  {!! HTML::script(asset('bower_components/OwlCarousel/owl-carousel/owl.carousel.js')) !!}
  <!--Set Invew Js-->
  {!! HTML::script(asset('dist/js/inview.js')) !!}
  <!--Set Animate Js-->
  {!! HTML::script(asset('dist/js/animate.js')) !!}
  <!--Set Validate Js-->
  {!! HTML::script(asset('dist/js/validate.js')) !!}
  <!--Set Custom Js-->
  {!! HTML::script(asset('dist/js/custom.js')) !!}
  <!--Custom CK -->
  {!! HTML::script(asset('vendors/ckeditor/ckeditor.js')) !!}
	<!--Custom Validator-->
	{!! HTML::script(asset('vendors/validator/validator.min.js'), array('async' => 'async'))!!}
	<!--Custom DatePicker-->
	{!! HTML::script(asset('bower_components/datepicker/js/bootstrap-datepicker.js'))!!}
  <!--Set Admin Js-->
  @if(isset($js) && is_array($js))
    @foreach($js as $script)
      <script src="{{asset($script)}}"></script>
    @endforeach
  @endif
</body>
</html>
