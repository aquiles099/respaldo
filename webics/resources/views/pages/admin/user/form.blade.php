<div class="container">
  <div class="row">
    <div class="span12">
      <div class="cform" id="contact-form">
        <form action="{{asset("$path")}}" method="post" onsubmit="icsDisableElement('sendButton')" data-toggle="validator">
          @if(isset($user))
            {{method_field('patch')}}
          @endif
          <!--Nombre-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.name')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'name'])">
                <input type="text" id="name"  name="name" class="form-control" value="{{isset($user) ? $user->name :Input::get('name')}}"  placeholder="{{trans('messages.name')}}" required="true" />
                @include('errors.errors', ['errors' =>  $errors, 'name' => 'name'])
              </div>
            </div>
          </div>
          <!--Telefono-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.phone')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'phone'])">
                <input type="text" id="phone"  name="phone" class="form-control" value="{{isset($user) ? $user->phone :Input::get('phone')}}"  placeholder="{{trans('messages.phone')}}" required="true" />
                @include('errors.errors', ['errors' =>  $errors, 'name' => 'phone'])
              </div>
            </div>
          </div>
          <!--Email-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.email')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'email'])">
                <input type="text" id="email"  name="email" class="form-control" value="{{isset($user) ? $user->email : Input::get('email')}}"  placeholder="{{trans('messages.email')}}" required="true" />
                @include('errors.errors', ['errors' =>  $errors, 'name' => 'email'])
              </div>
            </div>
          </div>
          <!-- Types -->
          <div class="row" style="margin-bottom: 30px">
            <div class="col-md-1 ">
              <label for="">{{trans('user.type')}}</label>
            </div>
            <div class="col-md-8">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'user_type'])">
                <select type="text" name="user_type" class="form-control icsselect" id="user_type" placeholder="{{trans('messages.type')}}" required="true"/>
                  @foreach($types as $key => $value)
                    <option {{isset($user) && $value->id == $user->user_type ? 'selected' : Input::get('user_type') == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                </select>
                  @include('errors.errors', ['errors' =>  $errors, 'name' => 'user_type'])
              </div>
            </div>
          </div>
          <!--Password-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.password')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'password'])">
                <input type="password" id="password"  name="password" class="form-control" value="{{Input::get('password')}}"  placeholder="{{trans('messages.password')}}" @if(!isset($user)) required="true" @endif />
                @include('errors.errors', ['errors' =>  $errors, 'name' => 'password'])
              </div>
            </div>
          </div>
          <!--Confirmation-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.password')}}*</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'password_confirmation'])">
                <input class="form-control" placeholder="{{trans('messages.repassword')}}" name="password_confirmation" type="password" data-match="#password"  confirmed @if(!isset($user))required="true"@endif>
                  @include('errors.errors', ['errors' =>  $errors, 'name' => 'password_confirmation'])
              </div>
            </div>
          </div>
          <!--Action-->
          <div class="row">
            <div class="col-md-1 ">
            </div>
            <div class="col-md-8 ">
              <!-- Action -->
              <button id="sendButton" type="submit" class="btn btn-primary pull-right">{{trans('messages.send')}}</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
