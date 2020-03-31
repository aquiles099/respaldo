<?php
if(isset($package) && !is_null($package->getLastEvent)) {
  $position = $package->getLastEvent->step;
}
else {
  $position = -1;
}
?>
@set('only')
<?php
use App\Helpers\HUserType;
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
@set('js', ['js/includes/resellerCtrl.js'])
@section('pageTitle', trans('messages.account'))
@section('icon-title')
  <i aria-hidden="true" class="fa fa-cloud-upload"></i>
@stop
@section('title', trans('messages.uploadinvoice'))
@extends('pages.page')
@include('sections.translate')
@section('title-actions')
@stop
@section('body')
@include('sections.messages')
<div class="panel panel-default">
  <div class="panel-heading text-center">
    <span class="text-muted">
      <i class="fa fa-cloud-upload" aria-hidden="true"></i>
      {{trans('messages.uploadinvoice')}}
    </span>
  </div>
  <div class="panel-body">
    <fieldset>
      <form onsubmit="submitForm()" role="form" method="post" action="{{asset("account/upload/{$package->id}")}}" enctype="multipart/form-data">
        <fieldset>
          {{csrf_field()}}
          <!---->
          <div class="form-group row @include('errors.field-class', ['field' => 'carrier'])" id="carrier" >
            <div class="col-lg-3">
              <label for="content" id="label">{{trans('messages.carrier')}}</label>
            </div>
            <div class="col-lg-9">
              <select class="form-control" id="carrier" name="carrier" required="true" @include('form.readonly') disabled="true">
                @foreach ($couriers as $courier)
                  <option {{(isset($package->from_courier) ? $package->from_courier : Input::get('from_courier')) == $courier->id ? 'selected' : ''}} value="{{$courier->id}}">{{$courier->name}}</option>
                @endforeach
              </select>
              @include('sections.errors', ['errors' =>  $errors, 'name' => 'carrier'])
            </div>
          </div>
          <!--{{--Contenido del paquete--}}-->
          <div class="form-group row @include('errors.field-class', ['field' => 'contentPackage'])">
              <div class="col-lg-3">
                <label for="content" id="label">{{trans('messages.contentPackage')}}</label>
              </div>
              <div class="col-lg-9">
                <input class="form-control" placeholder="{{trans('messages.contentPackage')}}" name="contentPackage" type="text" autofocus value="{{ Input::get('contentPackage') }}" required="true">
                @include('sections.errors', ['errors' =>  $errors, 'name' => 'contentPackage'])
              </div>
          </div>
          <!--{{--Costo del paquete--}}-->
          <div class="form-group row @include('errors.field-class', ['field' => 'pricePackage'])">
            <div class="col-lg-3">
              <label for="content" id="label">{{trans('messages.pricePackage')}}</label>
            </div>
            <div class="col-lg-9">
              <input class="form-control" placeholder="{{trans('messages.pricePackage')}}" name="pricePackage" type="number" autofocus value="{{ Input::get('pricePackage') }}" required="true">
              @include('sections.errors', ['errors' =>  $errors, 'name' => 'pricePackage'])
            </div>
          </div>
          <!--{{--Archivo a Subir--}}-->
          <div class="form-group row @include('errors.field-class', ['field' => 'id_package'])">
            <div class="col-lg-3">
              <label for="upload-photo" id="label">{{trans('messages.selectfile')}}</label>
            </div>
            <div class="col-lg-1">
              <input style="padding: 0px" type="file" class="hidden2"  name="file" id="upload_file" accept=".pdf, image/*" onchange="preview_image()" autofocus value="{{ Input::get('file') }}" required=true multiple="false">
              @include('sections.errors', ['errors' =>  $errors, 'name' => 'id_package'])
            </div>
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
          <input type="hidden" name="id_package" value="{{$package->id}}">
          <input type="hidden"  name="id_carrier" value="{{isset($package->getCourier) ? $package->getCourier->id : ''}}">
          <!---->
          <div class="form-group">
            <span class="pull-left">
              <div class="" id="divload"></div>
            </span>
            <span class="pull-right">
                  <button  type = "submit" class="btn btn-primary">{{trans('messages.send')}} </button>
            </span>
          </div>
         </fieldset>
        </form>
    </fieldset>
  </div>
</div>
@stop
