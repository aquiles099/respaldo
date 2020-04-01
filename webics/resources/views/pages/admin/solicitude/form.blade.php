<div class="container">
  <div class="row">
    <div class="span12">
      <div class="cform" id="contact-form">
        <form action="{{asset("$path")}}" method="post" onsubmit="icsGeneralLoad('sendButton')">
          @if(isset($solicitude))
            {{method_field('patch')}}
          @endif
          <!--Nombre-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.name')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'name'])">
                <input type="text" id="name"  name="name" class="form-control" value="{{isset($solicitude) ? $user->name :Input::get('name')}}"  placeholder="{{trans('messages.name')}}" required="true" />
                @include('errors.field', ['field' => 'name'])
              </div>
            </div>
          </div>
          <!--Asunto-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.subject')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'subject'])">
                <input type="text" id="subject"  name="subject" class="form-control" value="{{isset($solicitude) ? $solicitude->subject : Input::get('subject')}}"  placeholder="{{trans('messages.subject')}}" required="true" />
                @include('errors.field', ['field' => 'subject'])
              </div>
            </div>
          </div>
          <!--Correo-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.email')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'email'])">
                <input type="text" class="form-control" name="email" id="email" value="{{isset($solicitude) ? $solicitude->getClient->name : Input::get('email')}}" placeholder="{{trans('messages.email')}}" required="true"/>
                @include('errors.field', ['field' => 'email'])
              </div>
            </div>
          </div>
          <!--Perfil-->
          <div class="row" style="margin-bottom: 32px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.profile')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'profile'])">
                <select class="form-control" name="profile" >
                  <option value="0">{{trans('messages.profile')}} - {{trans('messages.selectoption')}}</option>
                  @foreach($profiles as $key => $value)
                  <option value="{{$value['id']}}">{{$value['text']}}</option>
                  @endforeach
                </select>
                @include('errors.field', ['field' => 'profile'])
              </div>
            </div>
          </div>
          <!--Message-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.message')}}</label>
            </div>
            <div class="col-md-8">
              <div class="field message form-group @include('errors.field-class', ['field' => 'description'])">
                <textarea class="form-control" name="description" id="mailmessage" rows="5"  placeholder="{{trans('messages.message')}}" required="true">{{isset($solicitude) ? $solicitude->description : Input::get('description')}}</textarea>
                @include('errors.field', ['field' => 'description'])
              </div>
            </div>
          </div>
          <!--Action-->
          <div class="row">
            <div class="col-md-1 ">
            </div>
            <div class="col-md-8 ">
              <!-- Action -->
              <button id="sendButton" type="submit" class="btn btn-primary pull-right" name="button">{{trans('messages.send')}}</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
