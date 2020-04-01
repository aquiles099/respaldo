@section('title-page', trans('messages.login'))
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
	<div class="container">
		<div class="blankdivider30"></div>
		<h4>{{trans('messages.login')}}</h4>
		<div class="row">
			<div class="span12">
				<div class="cform" id="contact-form">
					<form action="{{asset('/login')}}" method="post">
						<div class="row">
	            <div class="col-md-4 col-md-offset-4">
								@include('sections.messages')
	              <!--Email-->
	              <div class="field your-email form-group @include('errors.field-class', ['field' => 'email'])">
	                <input type="text" id="email"  name="email" class="form-control" value="{{Input::get('email')}}"  placeholder="{{trans('messages.email')}}" required="true" />
	                @include('errors.field', ['field' => 'email'])
	              </div>
	              <!-- Password -->
	              <div class="field subject form-group @include('errors.field-class', ['field' => 'password'])">
	                <input type="password" id="password" name="password" class="form-control"  placeholder="{{trans('messages.password')}}" required="true" />
	                @include('errors.field', ['field' => 'password'])
	              </div>
	              <!-- Action -->
								<div class="">
									<a href="{{asset('recover-password')}}" style="color: #2E5179"><i class="fa fa-lock" aria-hidden="true"></i><strong> {{trans('messages.recoverpass')}}</strong></a>
									<input type="submit" value="{{trans('messages.send')}}" class="btn btn-theme pull-right icsbgfoot">
								</div>
	            </div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@stop
