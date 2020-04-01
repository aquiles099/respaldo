<form action="{{asset("$path")}}" method="post" >
  @if(isset($prices))
    {{method_field('patch')}}
  @endif
  <!--Precios para versión basica-->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-cubes fa-fw" aria-hidden="true"></i>
        <span>{{trans('messages.basicICS')}}</span>
      </div>
      <div class="panel-body">
        <div class="col-md-5 col-md-offset-3 ">
          <div class="portfolio-item grid print photography">
            <div class="portfolio icscircle">
              <img  src="{{asset('dist/img/icon/micro.png')}}" alt="{{trans('messages.basicICS')}}" />
            </div>
          </div>
        </div>
      </div>
      <table class="table table-responsive table-hover icstablecenter">
          <thead>
            <tr>
              <th>{{trans('prices.licence')}}</th>
              <th>{{trans('prices.monthly')}}</th>
              <th>{{trans('prices.annual')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($prices as $key => $value)
              @if($value->type == App\Helpers\HProfileType::BASIC)
              <tr item="{{$value->toJson()}}">
                <td>{{$value->years}} año/s</td>
                <td>
                  <div class="@include('errors.field-class', ['field' => "basic_montly_{{$key + 1}}_year"])">
                    <input type="text" name="basic_montly_{{$key + 1}}_year" value="{{$value->monthly}}" style="height: 30px">
                  </div>
                  @include('errors.field', ['field' => "basic_monthly_{{$key + 1}}_year"])
                </td>
                <td>
                  <div class="@include('errors.field-class', ['field' => "basic_annual_{{$key + 1}}_year"])">
                    <input type="text" name="basic_annual_{{$key + 1}}_year" value="{{$value->annual}}" style="height: 30px">
                  </div>
                  @include('errors.field', ['field' => "basic_annual_{{$key + 1}}_year"])
                </td>
              </tr>
              @endif
            @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <!--Precios para versión profesional-->
  <div class="col-md-6">
    <div class="panel panel-default">
      <!---->
      <div class="panel-heading">
        <i class="fa fa-rocket fa-fw" aria-hidden="true"></i>
        <span>{{trans('messages.profesionalICS')}}</span>
      </div>
      <!---->
      <div class="panel-body">
        <div class="col-md-5 col-md-offset-3 ">
          <div class="portfolio-item grid print photography">
            <div class="portfolio icscircle">
              <img  src="{{asset('dist/img/icon/macro.png')}}" alt="{{trans('messages.profesionalICS')}}" />
            </div>
          </div>
        </div>
      </div>
      <!---->
      <table class="table table-responsive table-hover icstablecenter">
          <thead>
            <tr>
              <th>{{trans('prices.licence')}}</th>
              <th>{{trans('prices.monthly')}}</th>
              <th>{{trans('prices.annual')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($prices as $key => $value)
              @if($value->type == App\Helpers\HProfileType::PROFESSIONAL)
              <tr item="{{$value->toJson()}}">
                <td>{{$value->years}} año/s </td>
                <td>
                  <div class="@include('errors.field-class', ['field' => "professional_montly_{{ (($key + 1) > 3) ? $key - 2 : $key + 1 }}_year"])">
                    <input type="text" name="professional_montly_{{ (($key + 1) > 3) ? $key - 2 : $key + 1 }}_year" value="{{$value->monthly}}" style="height: 30px">
                  </div>
                  @include('errors.field', ['field' => "professional_montly_{{ (($key + 1) > 3) ? $key - 2 : $key + 1 }}_year"])
                </td>
                <td>
                  <div class="@include('errors.field-class', ['field' => "professional_annual_{{ (($key + 1) > 3) ? $key - 2 : $key + 1 }}_year"])">
                    <input type="text" name="professional_annual_{{ (($key + 1) > 3) ? $key - 2 : $key + 1 }}_year" value="{{$value->annual}}" style="height: 30px">
                  </div>
                  @include('errors.field', ['field' => "professional_annual_{{ (($key + 1) > 3) ? $key - 2 : $key + 1 }}_year"])
                </td>
              </tr>
              @endif
            @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <!--Action-->
  <button id="sendButton" type="submit" class="btn btn-primary pull-right" name="button">{{trans('messages.send')}}</button>
</form>
