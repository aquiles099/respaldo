<!-- Include header[Components]-->
@include('sections.header')
<!-- Include Header[Nav-Options]-->
@include('sections.header-nav')
<!-- Include Body[Front-Web]-->
@if(is_null(Session::get('key-sesion')))
	@yield('body')
@else
	<!-- Include Body[Admin-body]-->
	@include('sections.page-admin')
@endif
<!-- Include Footer-Page[map-contact-social]-->
@if(is_null(Session::get('key-sesion')))
		@include('sections.footer-page')
@endif
<!-- Include Footer-Page[legal]-->
@include('sections.footer')
