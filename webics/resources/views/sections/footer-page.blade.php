<section class="spacer icsbgfoot">
	<div class="container">
		<div class="row">
			<!--Address & Social-->
			<div class="col-md-4">
				<h6 style="color:white">
					<p>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						 <span>Av. Balboa PH Bay Mall Piso 3 Oficina 304, Ciudad de Panamá, Panamá.</span>
					</p>
					<p>
						<i class="fa fa-phone" aria-hidden="true"></i>
						 <span>+507 3884416 / 3884417.</span>
					</p>
					<p>
						<i class="fa fa-envelope" aria-hidden="true"></i>
						 <span>{{env('ICS_MAIL_ADDRESS')}}.</span>
					</p>
				</h6>
				<h6 style="color:white">
					<ul class="icsactionhorizontal">
						<li>
							<a href="{{env('ICS_FACEBOOK_URL')}}" target="_blank" data-toggle="tooltip" data-placement="top">
								<img src="{{asset('dist/img/icon/FB.png')}}" alt="" />
							</a>
						</li>
						<li>
							<a href="{{env('ICS_TWITTER_URL')}}" target="_blank" data-toggle="tooltip" data-placement="top">
								<img src="{{asset('dist/img/icon/TW.png')}}" alt="" />
							</a>
						</li>
						<li>
							<a href="{{env('ICS_INSTAGRAM_URL')}}" target="_blank" data-toggle="tooltip" data-placement="top">
								<img src="{{asset('dist/img/icon/IG.png')}}" alt="" />
							</a>
						</li>
					</ul>
				</h6>
				<h6 style="color:white; margin-top: 21%">
					<p>
						<b>
							<a href="{{asset('/privacy')}}" style="color:white">Politicas de Privacidad</a>
						</b>
					</p>
				</h6>
				<h6 style="color:white; margin-top: 0%">
					<p>
						<b>
							<a href="{{asset('/terms')}}" style="color:white">Términos y Condiciones</a>
						</b>
					</p>
				</h6>
			</div>
			<!--Map-->
			<div class="col-md-4">
				<h1>@include('sections.map')</h1>
			</div>
			<!--Contact-->
			<div class="col-md-4" id="us">
				<div style="padding-top: 2%">
					<form action="{{asset('/contact')}}" method="post" role="form" class="contactForm" onsubmit="icsGeneralLoad('sendButton')">
						<!-- Name -->
						<div class="field your-name form-group @include('errors.field-class', ['field' => 'name'])">
							<input type="text" name="name" class="form-control" id="name" placeholder="{{trans('messages.name')}}" style="height: 35px;     margin-bottom: 0px" required="true"/>
							@include('errors.field', ['field' => 'name'])
						</div>
						<!-- Email -->
						<div class="field your-email form-group @include('errors.field-class', ['field' => 'email'])">
							<input type="text" class="form-control" name="email" id="email" placeholder="{{trans('messages.email')}}" style="height: 35px;     margin-bottom: 0px" required="true"/>
							@include('errors.field', ['field' => 'email'])
						</div>
						<!-- Subject-->
						<div class="field subject form-group @include('errors.field-class', ['field' => 'subject'])">
							<input type="text" class="form-control" name="subject" id="subject" placeholder="{{trans('messages.subject')}}" style="height: 35px;     margin-bottom: 0px" required="true"/>
							@include('errors.field', ['field' => 'subject'])
						</div>
						<!-- Description -->
						<div class="field message form-group @include('errors.field-class', ['field' => 'message'])">
							<textarea class="form-control" name="message" id="message" rows="5" placeholder="{{trans('messages.message')}}" style="height: 105px;     margin-bottom: 0px" required="true"></textarea>
							@include('errors.field', ['field' => 'message'])
						</div>
						<button id="sendButton" type="submit" class="btn btn-theme pull-right">{{trans('messages.send')}}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
