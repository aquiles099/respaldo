@section('title-page', trans('messages.error'))
@section('admin-page-title', trans('messages.error'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
  	<h4>{{trans('messages.error')}}</h4>
  	<div class="row">
  		<div class="span12">
        <p>
          <h1 class="text-center"><i class="fa fa-ban" aria-hidden="true"></i></h1>
        </p>
        <div class="">
          <div class="alert alert-danger" role="alert">
            <p>
              <strong>Error:</strong> {{$error}}
            </p>
            <p>
              <strong>Peticion Actual:</strong> {{$method}}
            </p>
          </div>
      </div>
    </div>
  </div>
</section>
@stop
