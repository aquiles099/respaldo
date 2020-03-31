<div class="panel panel-default">
  <div class="panel-body">
    <form role="form" action = "" class = "form-horizontal" id="ics_formSerial">
      @if(isset($receipt))
        {{csrf_field()}}
      @endif
      <fieldset>
        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'concept'])">
          <label for = "concept" class = "control-label col-md-2">{{trans('invoice.concept')}}</label>
          <div class = "col-md-10">
            <input type = "text" class = "form-control" id = "concept" name="concept" placeholder = "{{trans('invoice.concept')}}" value="{{(isset($receipt) ? ($receipt->getPackage != null) ? $receipt->getPackage->code : $receipt->getPickup->code  : Input::get('concept') )}}" required="true">
          </div>
            @include('errors.field', ['field' => 'concept'])
        </div>
        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type" >
          <label class="col-lg-2 control-label" for = "type"  id="typeLabel" >{{trans('invoice.type')}}</label>
          <div class="col-lg-10">
            <select class="form-control" id="type" name="type" required="true" value="{{ Input::get('type') }}">
                @foreach ($payTypes as $payType)
                  <option item="{{$payType['id']}}" value="{{$payType['id']}}">{{$payType['text']}}</option>
                @endforeach
            </select>
          </div>
          @include('errors.field', ['field' => 'type'])
        </div>
        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'value'])">
          <label for = "value" class = "control-label col-md-2">{{trans('invoice.value')}}</label>
          <div class = "col-md-10">
            <input type = "number" class = "form-control" id = "value" name="value" placeholder = "{{trans('invoice.valueExample')}} maximo: {{$receipt->getInvoice->value}}" value="{{isset($receipt) ? $receipt->getInvoice->value : Input::get('value') }}" required="true">
          </div>
          @include('errors.field', ['field' => 'value'])
        </div>
        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'observation'])">
          <label for = "observation" class = "control-label col-md-2">{{trans('invoice.observation')}}</label>
          <div class = "col-md-10">
            <textarea type = "number" class = "form-control" id = "observation" name="observation" placeholder = "{{trans('invoice.observation')}}" value="{{ Input::get('observation') }}" required="true"></textarea>
          </div>
          @include('errors.field', ['field' => 'observation'])
        </div>
        <!---->
        @if($receipt->getInvoice->value != 0)
        <div class="pull-right">
          <div class = "">
            <button type="button" class="btn btn-primary" onclick="executePaid({{isset($receipt) ? $receipt->id : '' }})">{{trans('invoice.send')}}</button>
          </div>
        </div>
        @endif
        <!---->
        <div class="pull-right" style="margin-right: 1%; margin-top: 3%;" id="alertOnProcess">
          <div class="ics-checkpayd" id="ics-checkpayd"></div>
        </div>
      </fieldset>
		</form>
  </div>
</div>
