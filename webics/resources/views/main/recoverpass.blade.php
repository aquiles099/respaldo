@section('title-page', trans('messages.recoverpass'))
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
	<div class="container">
		<div class="blankdivider30"></div>
		<h4>{{trans('messages.recoverpass')}}</h4>
		<div class="row">
			<div class="span12">
				<div class="cform" id="contact-form">
					<form action="{{asset('/recover-password')}}" method="post" onsubmit="icsGeneralLoad('sendButton')">
						<div class="row">
	            <div class="col-md-4 col-md-offset-4">
								@include('sections.messages')
	              <!--Email-->
	              <div class="field your-email form-group @include('errors.field-class', ['field' => 'email'])">
	                <input type="text" id="email"  name="email" class="form-control" value="{{Input::get('email')}}"  placeholder="{{trans('messages.email')}}" required="true" />
	                @include('errors.field', ['field' => 'email'])
	              </div>
	              <!-- Action -->
								<div class="">
									<input id="sendButton" name="sendButton" type="submit" value="{{trans('messages.send')}}" class="btn btn-theme pull-right icsbgfoot">
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
