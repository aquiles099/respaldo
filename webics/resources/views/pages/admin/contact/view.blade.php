<div class="panel panel-default">
  <div class="panel-heading">
    <i class="fa fa-inbox fa-fw" aria-hidden="true"></i>
    {{trans('contact.webcontacts')}}
  </div>
  <div class="panel-body">
    <!---->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-user fa-fw" aria-hidden="true"></i>
          {{trans('contact.sendby')}}
        </div>
        <div class="panel-body">
          <!--Nombre-->
          <p>
            <strong>{{trans('messages.name')}}:</strong> {{$contact->name}}
          </p>
          <!--CORREO-->
          <p>
            <strong>{{trans('messages.email')}}:</strong> {{$contact->email}}
          </p>
        </div>
      </div>
    </div>
    <!---->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-asterisk" aria-hidden="true"></i>
          {{trans('contact.general')}}
        </div>
        <div class="panel-body">
          <!--FECHA-->
           <p>
             <strong>{{trans('messages.created_at')}}:</strong> {{$contact->created_at}}
           </p>
           <!--ASUNTO-->
           <p>
             <strong>{{trans('messages.subject')}}:</strong> {{$contact->subject}}
           </p>
        </div>
      </div>
    </div>
    <!---->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
          {{trans('contact.emisormessage')}}
        </div>
        <div class="panel-body">
          {{$contact->message}}
        </div>
      </div>
    </div>
    <!---->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>
          {!! trans('messages.response') !!}
        </div>
        <div class="panel-body">
          {!! isset($email->message) ? $email->message : trans('messages.noresponse') !!}
        </div>
        <div class="panel-footer">
          <strong>{{trans('messages.attendedby')}}:</strong>
          {!! isset($email->message) ? strtoupper($email->getAdmin->name) : trans('messages.unknown') !!}
        </div>
      </div>
    </div>
  </div>
</div>
