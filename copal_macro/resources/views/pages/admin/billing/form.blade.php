<form  role="form" action="{{asset('admin/billing')}}" method="post" >
  <fieldset class="form">
    {{csrf_field()}}
    <!-- type of document -->
    <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type"}}>
      <label class="col-lg-2 control-label" id="typeLabel" >{{trans('billing.reportType')}}</label>
      <div class="col-lg-10">
        <select class="form-control" id="typeSelect" name="typeSelect"   >
          @if(is_array($types) || is_object($values))
            @foreach($types as $type)
              <option {{isset($typeReport) ? ($typeReport == $type['id']) ? 'selected' : '' : '' }} value="{{$type['id']}}">{{$type['text']}}</option>
            @endforeach
          @endif
        </select>
      </div>
        @include('errors.field', ['field' => 'type'])
    </div>
    <!---->
    <div class="row">
      <div class="col-lg-6">
        <div class="form-group row @include('errors.field-class', ['field' => 'since_date'])"}}>
          <label class="col-lg-4 control-label" id="dateFromLabel" >{{trans('billing.dateFrom')}}</label>
          <div class="col-lg-8">
            <div class="input-group" id="">
                <input class="form-control" type="text" placeholder = "{{trans('billing.dateFrom')}}" name="since_date" id="since_date" value="{{isset($typeReport) ? Input::get('since_date'): '' }}" >
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
              @include('errors.field', ['field' => 'since_date'])
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row @include('errors.field-class', ['field' => 'until_date'])"}}>
          <label class="col-lg-4 control-label" id="dateToLabel" >{{trans('billing.dateTo')}}</label>
          <div class="col-lg-8">
            <div class="input-group" id="">
              <input class="form-control" type="text" placeholder = "{{trans('billing.dateTo')}}" name="until_date" id="until_date" value="{{isset($typeReport) ? Input::get('until_date'): '' }}" >
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
              @include('errors.field', ['field' => 'until_date'])
          </div>
        </div>
      </div>
      </div>
    <!--send data -->
    @if(!isset($readonly) || !$readonly)
      <div class="pull-right">
        <button type="submit" class="btn btn-primary" >
          <i class="fa fa-search" aria-hidden="true"></i>
          {{trans('billing.search')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
