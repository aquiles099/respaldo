<?php
use App\Helpers\HUserType;
use App\Helpers\HConstants;
?>
@set('only')
<?php
  if (Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
@set('js', ['js/includes/resellerCtrl.js'])
@set('js', ['js/includes/prealertCtrl.js'])
@include('sections.translate')

@section('pageTitle', trans('messages.listprealert'))
@section('icon-title')
  <i aria-hidden="true" class="fa fa-flag"></i>
@stop
@section('title', trans('messages.listprealert'))
@extends('pages.page')
@section('title-actions')
<div class="btn-group" role="group" >
  <a href="{{asset('account/prealert/new')}}" onclick="loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('messages.newprealert')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
    {{trans('messages.create')}}
  </a>
  <a href="{{isset($filter) ? asset('account/prealert') : '#section' }}" class="btn btn-primary" @if(!isset($filter)) data-toggle="collapse" @endif>
    <span><i class="{{isset($filter) ? 'fa fa-list' : 'fa fa-filter' }}"></i></span>
    {{isset($filter) ? trans('messages.list') : trans('messages.filter')}}
  </a>
</div>
@stop
@section('body')
  @include('sections.messages')
    @include('pages.user.filter', [
      'path'  => 'account/prealert'
    ])
  <div class="panel panel-default" id="pnlin">
    <div class="panel-heading text-center">
      <span class="text-muted">
        <i class="fa fa-flag" aria-hidden="true"></i>
        {{trans('messages.listprealert')}}
      </span>
    </div>
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive" id="dtble_prealert">
        <thead>
          <tr>
            <th style="text-align:center">{{trans('prealert.code')}}</th>
            <th style="text-align:center">{{trans('prealert.order_service')}}</th>
            <th style="text-align:center">{{trans('prealert.provider')}}</th>
            <th style="text-align:center">{{trans('prealert.courier')}}</th>
            <th style="text-align:center">{{trans('prealert.date_arrived')}}</th>
            <th style="text-align:center">{{trans('prealert.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($prealerts as $key => $prealert)
            @if(!isset($filter))
              @if($prealert->complete == HConstants::RESPONSE_NULL)
                <tr>
                  <td>{{$prealert->code}}</td>
                  <td><a class="infoRd" href="javascript:icsViewPrelert({{$prealert->id}})">{{$prealert->order_service}}</a></td>
                  <td>{{$prealert->provider}}</td>
                  <td>{{$prealert->getCourier->name}}</td>
                  <td>{{$prealert->date_arrived}}</td>
                  <td>
                    <ul class="table-actions">
                      {{--<li><a onclick="icsPrealertDelete({{$prealert->id}})" ><i class="fa fa-trash"  data-toggle="tooltip" title="{{trans('prealert.deletep')}}"></i></a></li>--}}
                      <li><a href="{{asset("account/prealert/{$prealert->id}")}}" ><i class="fa fa-pencil"  data-toggle="tooltip" title="{{trans('prealert.edit')}}"></i></a></li>
                    </ul>
                  </td>
                </tr>
              @endif
            @elseif($count > HConstants::EVENT_CERO)
              <tr>
                <td>{{$prealert->code}}</td>
                <td><a class="infoRd" href="javascript:icsViewPrelert({{$prealert->id}})">{{$prealert->order_service}}</a></td>
                <td>{{$prealert->provider}}</td>
                <td>{{$prealert->getCourier->name}}</td>
                <td>{{$prealert->date_arrived}}</td>
                <td>
                  <ul class="table-actions">
                    {{--<li><a onclick="icsPrealertDelete({{$prealert->id}})" ><i class="fa fa-trash"  data-toggle="tooltip" title="{{trans('prealert.deletep')}}"></i></a></li>--}}
                    @if($prealert->complete == HConstants::RESPONSE_NULL)
                      <li><a href="{{asset("account/prealert/{$prealert->id}")}}" ><i class="fa fa-pencil"  data-toggle="tooltip" title="{{trans('prealert.edit')}}"></i></a></li>
                    @endif
                  </ul>
                </td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
