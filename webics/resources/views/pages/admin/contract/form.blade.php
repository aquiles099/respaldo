<div class="container">
  <div class="row">
    <div class="span12">
      <div class="cform" id="contact-form">
        <form action="{{asset("$path")}}" method="post">
          @if(isset($contract))
            {{method_field('patch')}}
          @endif
          <!--Register-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('contract.register')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'register_date'])">
                <input type="text" id="register_date"  name="register_date" class="form-control" value="{{isset($contract) ? $contract->register_date :Input::get('register_date')}}"  placeholder="{{trans('messages.name')}}" required="true" />
                @include('errors.field', ['field' => 'register_date'])
              </div>
            </div>
          </div>
          <!--Cut-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('contract.cutoff_date')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'cut_off_date'])">
                <input type="text" id="cut_off_date"  name="cut_off_date" class="form-control" value="{{isset($contract) ? $contract->cut_off_date :Input::get('register_date')}}"  placeholder="{{trans('messages.name')}}" required="true" />
                @include('errors.field', ['field' => 'cut_off_date'])
              </div>
            </div>
          </div>
          <!--Status-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.status')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'status'])">
                <select type="text" name="status" class="form-control icsselect" id="status" required="true"/>
                  @foreach($status as $key => $value)
                    @if($value->id < 6)
                    <option {{isset($contract) && $contract->status == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                    @endif
                  @endforeach
                </select>
                @include('errors.field', ['field' => 'status'])
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
        </form>
      </div>
    </div>
  </div>
</div>
