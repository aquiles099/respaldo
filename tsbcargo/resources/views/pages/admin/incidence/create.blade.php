@include('sections.translate')
@section('pageTitle', trans('Incidencias'))
@section('title', trans('Reportar Incidencias'))
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
<script type="text/javascript">
      const CURRENT_LOCATION = window.location.origin;
      var op = "operator";
      var lang = '{!!$lang!!}';
      function translate () {
        if (lang == 'es') {
            return ({
              'wait' : 'Espere...',
              'msgSuccess': 'Su mensaje ha sido enviado con exito!',
              'errorTry' : 'ERROR: Ha ocurrido un problema al procesar su solicitud, por favor intente nuevamente.',
              'send' : 'Enviar'
            });
        }else {
          return ({
            'wait' : 'Wait...',
            'msgSuccess': 'Your message was sended succes!',
            'errorTry' : 'Error! Please try again',
            'send' : 'Send'
          });
        }
      }
      function loadTestStatus () {
        var url = asset('login')+"/loadtest";
          $.ajax({
              url: url,
              type: 'GET',
              beforeSend: function ()
              {

              },
              success: function (json)
              {
                op = (json.operator);
              }
            });
            return op;
      }

      function verifyImputs(){
        if ($('#incidence_select').val()=='') {
          return false;
        }
        if ($('#incidence_subject').val()=='') {
          return false;
        }
        return true;
      }
      var createLoad = function ()
      {
        if (verifyImputs()) {
          var operator   = loadTestStatus();
          var url        = "http://www.internationalcargosystem.com/api/incidence/new";
          var img        = $('#screen').val().replace("C:\\fakepath\\", "");
          img = 'http://macro.internationalcargosystem.com/uploads/incidence/'+ img;
          for (var i = 0; i < img.length; i++) {
                img = img.replace(" ","");
          }
          var dataString =
            {
              'subject' : $('#incidence_subject').val(),
              'type' : $('#incidence_select').val(),
              'description' : $('#incidence_description').val(),
              'image' : img,
              'perfil': 'micro',
              'email': operator.email
            };
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: dataString,
                beforeSend: function ()
                {
                  $('#divButton').attr('disabled','true');
                  $('#divButton').html("<button type='submit' disabled class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+translate().wait+"</button>");
                },
                success: function (json)
                {
                  if (json.message == true) {
                    bootbox.alert({
                      message: translate().msgSuccess,
                      size: 'medium',
                      callback: function (){
                        $('#formulario').submit();
                      }
                    });
                  }
                },
                error: function(){
                  bootbox.alert({
                    message: translate().errorTry,
                    size: 'medium',
                    callback: function (){
                      $('#divButton').html("<button type='submit' onclick='createLoad()' class='btn btn-primary pull-right'><i class='fa fa-paper-plane-o'></i> "+translate().send+"</button>");
                    }
                  });
                }
              });
        }else{
          //$('#formulario').submit();
        }

      }
      $(document).ready(() => {
          $('#incidence_select').select2();
      });
</script>
  <div class="col-md-12">
      <form id="formulario" role="form" action="{{asset('admin/incidence/new')}}" method="post" enctype="multipart/form-data">
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
