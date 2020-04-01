<div class="panel panel-default">
  <div class="panel-heading">
    <i class="fa fa-envelope fa-fw"></i>
    {{trans('mail.info')}}
  </div>
  <div class="panel-body">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-user fa-fw" ></i>
            {{trans('mail.userinfo')}}
          </div>
          <div class="panel-body">
            <!--Receptor-->
            <p>
              <strong>{{trans('mail.sendto')}}:</strong> {{$mail->email}}
            </p>
            <!--Emisor-->
            <p>
              <strong>{{trans('mail.sendby')}}:</strong> {{$mail->getUser->code}} - {{$mail->getUser->name}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-asterisk" aria-hidden="true"></i>
            {{trans('mail.general')}}
          </div>
          <div class="panel-body">
            <p>
              <strong>{{trans('mail.subject')}}:</strong> {{$mail->subject}}
            </p>
            <!--Asunto-->
            <p>
              <strong>{{trans('mail.date')}}:</strong> {{$mail->created_at}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-pencil fa-fw"></i>
            {{trans('mail.message')}}
          </div>
          <div class="panel-body">
            {!!$mail->message!!}
          </div>
        </div>
      </div>
  </div>
</div>
