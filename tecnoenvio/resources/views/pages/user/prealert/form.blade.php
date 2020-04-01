<script type="text/javascript">
  $(document).ready(function () {
    $('#consolidated').select2();
  });
</script>
<form onsubmit="createLoad()" class="form" role="form" action="{{asset($path)}}" method="post" enctype="multipart/form-data" files="true" data-toggle="validator">
  <fieldset>
    @if(isset($prealert))
      <input type="hidden" name="_method" value="patch">
    @endif
    <!--courier select-->
    <div class="form-group row @include('errors.field-class', ['field' => 'courier'])">
      <div class="col-lg-3">
        <label for="courierSelect">{{trans('messages.carrier')}}</label>
      </div>
      <div class="col-lg-9">
        <select class="form-control" id="courierSelect" name="courier" style="width: 100% !important" autofocus="true">
          @foreach ($couriers as $key => $courier)
            <option {{isset($prealert) && $prealert->courier == $courier->id ? 'selected' : '' }} value="{{$courier->id}}">{{strtoupper($courier->name)}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'courier'])
      </div>
    </div>
    <!--provider-->
    <div class="form-group row @include('errors.field-class', ['field' => 'provider'])">
      <div class="col-lg-3">
        <label for="courierSelect">{{trans('prealert.provider')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('prealert.infoprovider')}}"></i></label>
      </div>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('prealert.provider')}}" id="provider" name="provider" type="text" required="true" value="{{isset($prealert) ? $prealert->provider : clear(Input::get('provider'))}}" >
        @include('errors.field', ['field' => 'provider'])
      </div>
    </div>
    <!--service order-->
    <div class="form-group row @include('errors.field-class', ['field' => 'order_service'])" id="">
      <div class="col-lg-3">
        <label for="service_order">{{trans('messages.service_order')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('prealert.infoorder')}}"></i></label>
      </div>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.service_order')}}" id="service_order" name="order_service" type="text" required="true" value="{{isset($prealert) ? $prealert->order_service : clear(Input::get('order_service'))}}" >
        @include('errors.field', ['field' => 'order_service'])
      </div>
    </div>
    <!--value-->
    <div class="form-group row @include('errors.field-class', ['field' => 'value'])" id="">
      <div class="col-lg-3">
        <label for="value">{{trans('messages.value')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('prealert.infovalue')}}"></i></label>
      </div>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.value')}} $" id="value" name="value" type="text"  required="true" value="{{isset($prealert) ? $prealert->value : clear(Input::get('value'))}}" >
        @include('errors.field', ['field' => 'value'])
      </div>
    </div>
    <!--content-->
    <div class="form-group row @include('errors.field-class', ['field' => 'content'])" id="">
      <div class="col-lg-3">
        <label for="value">{{trans('messages.content')}}</label>
      </div>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.content')}}" id="content" name="content" type="text"  required="true" value="{{isset($prealert) ? $prealert->content : clear(Input::get('content'))}}" >
        @include('errors.field', ['field' => 'content'])
      </div>
    </div>
    <!--arrivedate-->
    <div class="form-group row @include('errors.field-class', ['field' => 'date_arrived'])" id="">
      <div class="col-lg-3">
        <label for="value">{{trans('messages.arrivedate')}}</label>
      </div>
      <div class="col-lg-9">
          <div class="input-group">
            <input class="form-control" placeholder="{{trans('messages.arrivedate')}}" id="arrivedate" name="date_arrived" type="text"  required="true" value="{{isset($prealert) ? $prealert->date_arrived : clear(Input::get('date_arrived'))}}" >
            <span class = "input-group-addon">
              <i aria-hidden="true" class="fa fa-calendar"></i>
            </span>
          </div>
            @include('errors.field', ['field' => 'date_arrived'])
      </div>
    </div>
    <!--consolidate-->
    <div class="form-group row @include('errors.field-class', ['field' => 'courier'])">
      <div class="col-lg-3">
        <label for="courierSelect">{{trans('messages.consolide')}}</label>
      </div>
      <div class="col-lg-9">
        <select class="form-control" id="consolidated" name="consolidated" style="width: 100% !important" autofocus="true">
          <option {{isset($prealert->consolide)&&($prealert->consolide == '0') ? 'selected' : ''}} value="0">{{trans('messages.unconsolidate')}}</option>
          <option {{isset($prealert->consolide)&&($prealert->consolide == '1') ? 'selected' : ''}} value="1">{{trans('messages.consolidate')}}</option>
        </select>
        @include('errors.field', ['field' => 'courier'])
      </div>
    </div>
    <!--{{--Archivo a Subir--}}-->
    <div class="form-group row @include('errors.field-class', ['field' => 'file'])">
      <div class="col-lg-3">
        <label for="upload-photo" id="label">{{trans('messages.selectfile')}}</label>
      </div>
      <div class="{{isset($removable) && $removable == true ? 'col-lg-2' : 'col-lg-1' }}">
        <input style="padding-left: 0px" type="file" class="hidden2"  name="file" id="upload_file" accept=".pdf, image/*" onchange="preview_image()"  multiple="false">
        @include('sections.errors', ['errors' =>  $errors, 'name' => 'file'])
      </div>
      @if(isset($prealert))
        <div class="{{isset($removable) && $removable == true ? 'col-lg-7' : 'col-lg-8' }}">
            <div class="breadcrumb">
              <i aria-hidden="true" class="fa fa-file-o"></i>
              <strong>{{trans('prealert.associatedfile')}}: </strong>
              <span class="text-muted">{{isset($prealert->getFile) ? $prealert->getFile->name : trans('prealert.notFile') }}</span>
            </div>
        </div>
      @endif
    </div>
    <!--{{--Archivo a Subir--}}-->
    <div>
      <div class="col-lg-3">
      </div>
      <div class="co-lg-9">
        <div id="image_preview" ></div>
      </div>
    </div>
    <!---->
    @if(isset($prealert))
    <div class="pull-left text-muted">
      <i aria-hidden="true" class="fa fa-eye"></i>
      {{strtoupper(trans('prealert.notificationsprealert'))}}
    </div>
    @endif
    <!---->
    <div class="form-group" id="divButton" >
      <span class="pull-left">
        <div id="divload"></div>
      </span>
      <span class="pull-right">
        <button  type="submit" class="btn btn-primary">{{trans('messages.send')}} </button>
      </span>
    </div>
  </fieldset>
</form>
