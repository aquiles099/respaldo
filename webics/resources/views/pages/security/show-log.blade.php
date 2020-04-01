@set('js', ['src/js/client.js'])
@section('title-page', trans('messages.activity'))
@section('admin-page-title', trans('messages.activity'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('admin-body')
  @while(!feof($log))
    @if(strpos(fgets($log), "INFO") || strpos(fgets($log), "NOTICE"))
      <div class="well">
        <i class="fa fa-eye" aria-hidden="true"></i>
        {!!fgets($log)!!}
      </div>
    @endif
  @endwhile
@stop
