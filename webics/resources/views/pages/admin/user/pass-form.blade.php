<div class="container">
  <div class="row">
    <div class="span12">
      <div class="cform" id="contact-form">
        <form action="{{asset("$path")}}" method="post" onsubmit="icsDisableElement('sendButton')" data-toggle="validator">
          @if(isset($user))
            {{method_field('patch')}}
          @endif
          <!--Current Password-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-5 col-md-offset-2">
              @include('sections.messages-short')
              <label for="">{{trans('messages.current')}}</label>
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'current'])">
                <input type="password" id="current"  name="current" class="form-control" value="{{Input::get('current')}}"  placeholder="{{trans('messages.password')}}" required="true" />
                @include('errors.errors', ['errors' =>  $errors, 'name' => 'current'])
              </div>
            </div>
          </div>
          <!--New Password-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-5 col-md-offset-2">
              <label for="">{{trans('messages.newpassword')}}*:</label>
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'pass'])">
                <input type="password" id="pass"  name="pass" class="form-control" value="{{Input::get('pass')}}"  placeholder="{{trans('messages.password')}}" required="true" />
                @include('errors.errors', ['errors' =>  $errors, 'name' => 'pass'])
              </div>
            </div>
          </div>
          <!--Re-Password-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-5 col-md-offset-2">
              <label for="">{{trans('messages.confirmpassword')}}*:</label>
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'pass'])">
                <input class="form-control" placeholder="{{trans('messages.repassword')}}" name="password_confirmation" type="password" data-match="#pass" required="true" />
                @include('errors.errors', ['errors' =>  $errors, 'name' => 'pass'])
              </div>
            </div>
          </div>
          <!--Action-->
          <div class="row">
            <div class="col-md-2 col-md-offset-3 ">
              <!-- Action -->
              <button id="sendButton" type="submit" class="btn btn-primary pull-right">{{trans('messages.send')}}</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
