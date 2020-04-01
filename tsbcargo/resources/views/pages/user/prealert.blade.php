<?php
if(isset($package) && !is_null($package->getLastEvent))
{
  $position = $package->getLastEvent->step;
}
else
{
  $position = -1;
}
?>

@set('only')
<?php
use App\Helpers\HUserType;
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER)
  {
    unset($only);
  }
?>
@set('js', ['js/includes/resellerCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('messages.account'))
@section('title', trans('messages.uploadFile'))
@extends('pages.page')
@section('title-actions')
@stop
@section('body')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
        @include('sections.messages')
      <div class="login-panel panel panel-default">
        <div class="panel-heading">
            <h4 class="">
              <span class="text-muted"><span class="pull-left">{{trans('messages.tracking')}}: {{$package->tracking}}</span>
              |
              <span class="pull-right">
                {{trans('package.status')}}:
                @if($package->getLastEvent->step == 1) {{trans('package.received')}} @endif
                @if($package->getLastEvent->step == 2) {{trans('package.processed')}} @endif
                @if($package->getLastEvent->step == 3) {{trans('package.inTransit')}} @endif
                @if($package->getLastEvent->step == 4) {{trans('package.available')}} @endif
                @if($package->getLastEvent->step == 5) {{trans('package.delivered')}}@endif
              </span>
              </span>
            </h4>
        </div>
        <div class="panel-body">
          <form onsubmit="submitForm()" role="form" method="post" action="{{asset("account/tracking/prealert/{$package->id}")}}" enctype="multipart/form-data">
            <fieldset >
              <!---->
              {{csrf_field()}}
              <!---->
              {{--Transportista designado en el Paquete--}}
              <label for="content" id="label">{{trans('messages.carrier')}}</label>
              <div class="form-group  @include('errors.field-class', ['field' => 'carrier'])" id="carrier" >
                <select class="form-control" id="carrier" name="carrier" required="true" @include('form.readonly') disabled="true">
                  @foreach ($couriers as $courier)
                    <option {{(isset($package->from_courier) ? $package->from_courier : Input::get('from_courier')) == $courier->id ? 'selected' : ''}} value="{{$courier->id}}">{{$courier->name}}</option>
                  @endforeach
                </select>
                @include('sections.errors', ['errors' =>  $errors, 'name' => 'carrier'])
              </div>
              <!---->
              {{--Contenido del paquete--}}
              <label for="content" id="label">{{trans('messages.contentPackage')}}</label>
              <div class="form-group @include('errors.field-class', ['field' => 'contentPackage'])">
                <input class="form-control" placeholder="{{trans('messages.contentPackage')}}" name="contentPackage" type="text" autofocus value="{{ Input::get('contentPackage') }}" required="true">
                @include('sections.errors', ['errors' =>  $errors, 'name' => 'contentPackage'])
              </div>
              <!---->
              {{--Costo del paquete--}}
              <label for="content" id="label">{{trans('messages.pricePackage')}}</label>
              <div class="form-group @include('errors.field-class', ['field' => 'pricePackage'])">
                <input class="form-control" placeholder="{{trans('messages.pricePackage')}}" name="pricePackage" type="text" autofocus value="{{ Input::get('pricePackage') }}" required="true">
                @include('sections.errors', ['errors' =>  $errors, 'name' => 'pricePackage'])
              </div>
              <!---->
              {{--Archivo a Subir--}}
              <label for="upload-photo" id="label">{{trans('messages.uploadFile')}}</label>
              <div class="form-group @include('errors.field-class', ['field' => 'id_package'])" style="padding-bottom: 8px; padding-top: 8px;">
                <input type="file" name="file" id="file" accept=".pdf, image/*" autofocus value="{{ Input::get('file') }}" required=true >
                @include('sections.errors', ['errors' =>  $errors, 'name' => 'id_package'])
              </div>
              <!---->
              <input type="hidden" name="id_package" value="{{$package->id}}">
              <input type="hidden"  name="id_carrier" value="{{$package->getCourier->id}}">
              <!---->
              <div class="form-group">
                <span class="pull-left">
                  <div class="" id="divload"></div>
                </span>
                <span class="pull-right">
                      <button  type = "submit" class="btn btn-success">{{trans('messages.send')}} <i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
                </span>
              </div>
             </fieldset>
            </form>
        </div>
      </div>
    </div>
  </div>
@stop
