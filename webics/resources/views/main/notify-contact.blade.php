@section('title-page', trans('messages.sendcontact'))
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
    <h4>{{trans('messages.sendcontact')}}</h4>
      <div class="row">
        <div class="span12">
         <div class="row">
           <div class="col-md-9">
             <p>
               <h5 class="icstitle">
                 Estimado (a): <strong>{{strtoupper($contact->name)}}</strong>, Gracias por contactárnos, en breve atenderemos su solictud.
               </h5>
             </p>
             <p>
               <h5>
                 <strong>Atentamente el equipo de ICS ©</strong>
               </h5>
             </p>
           </div>
           <div class="col-md-3">
               <div class="icsspacerequest">
                 <div class="icsbg flipInX animated">
                   <img class="icsspace2" src="{{asset('dist/img/icon/ic7.png')}}" alt="" />
                 </div>
               </div>
             </div>
         </div>
        </div>
      </div>
  </div>
</section>
@stop
