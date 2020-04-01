@set('js', ['src/js/security.js'])
@section('title-page', trans('messages.activity'))
@section('admin-page-title', trans('messages.activity'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('admin-body')
<!--Ver actividad-->
<div class="panel panel-default">
  <div class="panel-heading">
    <i class="fa fa-file-code-o" aria-hidden="true"></i>
    {{trans('activity.viewregisteractivity')}}
  </div>
  <div class="panel-body">
    <p>
      Realizar una visualizacion rapida de la actividad del sitio, esta descansa en el archivo de logs del sistema.
      <span class="label label-warning">
        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
         puede tardar en mostrarse
       </span>
    </p>
    <p>
      <a href="{{asset('admin/activity/showLog')}}" name="button" class="btn btn-primary">
        <i class="fa fa-chevron-right" aria-hidden="true"></i>
        {{trans('activity.goprocess')}}
      </a>
    </p>
  </div>
</div>
<!--Exportar Actvidad a Achivo-->
<div class="panel panel-default">
  <div class="panel-heading">
    <i class="fa fa-download" aria-hidden="true"></i>
    {{trans('activity.exportactivity')}}
  </div>
  <div class="panel-body">
    <p>
      Descargar un archivo con la actividad del sitio, este se exportará en formato plano para su visualizacion.
    </p>
    <p>
      <a  href="{{asset('admin/activity/exportLog')}}" name="sendButton" id="sendButton" class="btn btn-primary">
        <i class="fa fa-chevron-right" aria-hidden="true"></i>
        {{trans('activity.goprocess')}}
      </a>
    </p>
  </div>
</div>
@stop
