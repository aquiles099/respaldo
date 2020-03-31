@include('sections.translate')
@section('pageTitle', trans('Contacto'))
@section('title', trans('Contacto'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
@stop
@section('body')

<?php
    use App\Models\Admin\Configuration;

    $configuration = Configuration::find(1);
    $lang = $configuration->language;
 ?>
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
  <div class="col-md-12">
      <form id="formulario" role="form" action="{{asset('user/incidence/new')}}" method="post" enctype="multipart/form-data">
        <fieldset>
          <!--Tipo-->
          <div class="form-group row @include('errors.field-class', ['field' => 'incidence_type'])" style="padding-top: 8px;">
            <div class="col-lg-2"> </div>
            <label class="col-lg-1 control-label" for="incidence_type" id="label">{{trans('package.type')}}</label>
            <div class="col-lg-6">
              <select id="incidence_select"class="form-control select2" name="option_selected_label">
                <option value="0">{{trans('messages.errorRep')}}</option>
                <option value="1">{{trans('messages.need_help')}}</option>
              </select>
            </div>
         </div>
          <!--Asunto-->
          <div class="form-group row @include('errors.field-class', ['field' => 'incidence_subject'])" style="padding-top: 8px;">
            <div class="col-lg-2"> </div>
            <label class="col-lg-1 control-label" for="name_company" id="label">{{trans('messages.subject')}}</label>
            <div class="col-lg-6">
              <input required maxlength="195" min="1" class="form-control" type="text" id="incidence_subject" name="incidence_subject" placeholder="{{trans('messages.subject')}}" value="">
              @include('sections.errors', ['errors' =>  $errors, 'name' => 'name_company'])
            </div>
         </div>
        <!--Descripcion-->
         <div class="form-group row @include('errors.field-class', ['field' => 'incidence_description'])" >
           <div class="col-lg-2"> </div>
           <label class="col-lg-1 control-label" for="terms_ics" id="label">{{trans('messages.description')}}</label>
           <div class="col-lg-6">
             <textarea required type="text" style="height:100px;" class="form-control" id="incidence_description" name="incidence_description" placeholder="{{trans('messages.err_description')}}"></textarea>
             @include('sections.errors', ['errors' =>  $errors, 'name' => 'terms'])
           </div>
        </div>
        <div class="form-group row @include('errors.field-class', ['field' => 'incidence_description'])" >
          <div class="col-lg-2"> </div>
          <label style="margin-top: -10px;"class="col-lg-1 control-label" for="terms_ics" id="label">{{trans('messages.screen')}}</label>
          <div class="col-lg-6">
            <input type="file" class="file file-loading" name="screen" id="screen" accept="image/.jpg, image/.png" value="" >
            <input type="hidden" name="snap_screen" id="snap_screen" value="">
             @include('sections.errors', ['errors' =>  $errors, 'name' => 'screen'])
          </div>
        </div>
        <div class="col-md-12 buttons" id="divButton">
          <span id="divload"class="text-muted"></span>
          <button id ="loginButton" onclick="createLoad()" type="submit" class="btn btn-primary pull-right">
            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
            {{trans('messages.send_button')}}
          </button>
        </div>
        </fieldset>
        <br>
      </form>
  </div>
@stop
