@set('js', ['src/js/price.js'])
@section('title-page', trans('prices.prices'))
@section('admin-page-title', trans('prices.prices'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/prices/edit')}}" class="btn btn-primary" title="{{trans('prices.edit')}}">
  <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
  {{trans('prices.edit')}}
</a>
@stop
@section('admin-body')
  @include('sections.messages')
  @if ($prices->count() == 0)
    @include('sections.no-rows')
  @else
  @include('pages.admin.price.messages')
  <!--Precios para versión basica-->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-cubes fa-fw" aria-hidden="true"></i>
        <span>{{trans('messages.basicICS')}}</span>
      </div>
      <div class="panel-body">
        <div class="col-md-5 col-md-offset-3 ">
          <div class="portfolio-item grid print photography">
            <div class="portfolio icscircle">
              <img  src="{{asset('dist/img/icon/micro.png')}}" alt="{{trans('messages.basicICS')}}" />
            </div>
          </div>
        </div>
      </div>
      <table class="table table-responsive table-hover icstablecenter">
          <thead>
            <tr>
              <th>{{trans('prices.licence')}}</th>
              <th>{{trans('prices.monthly')}}</th>
              <th>{{trans('prices.annual')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($prices as $key => $value)
              @if($value->type == App\Helpers\HProfileType::BASIC)
              <tr item="{{$value->toJson()}}">
                <td>{{$value->years}} año/s {{$value->years == App\Helpers\HProfileType::BASIC ? '' : '**'}}</td>
                <td>{{$value->monthly}} {{env('CURRENCY')}}</td>
                <td>{{$value->annual}} {{env('CURRENCY')}}</td>
              </tr>
              @endif
            @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <!--Precios para versión profesional-->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-rocket fa-fw" aria-hidden="true"></i>
        <span>{{trans('messages.profesionalICS')}}</span>
      </div>
      <div class="panel-body">
        <div class="col-md-5 col-md-offset-3 ">
          <div class="portfolio-item grid print photography">
            <div class="portfolio icscircle">
              <img  src="{{asset('dist/img/icon/macro.png')}}" alt="{{trans('messages.profesionalICS')}}" />
            </div>
          </div>
        </div>
      </div>
      <table class="table table-responsive table-hover icstablecenter">
          <thead>
            <tr>
              <th>{{trans('prices.licence')}}</th>
              <th>{{trans('prices.monthly')}}</th>
              <th>{{trans('prices.annual')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($prices as $key => $value)
              @if($value->type == App\Helpers\HProfileType::PROFESSIONAL)
              <tr item="{{$value->toJson()}}">
                <td>{{$value->years}} año/s {{$value->years == App\Helpers\HProfileType::BASIC ? '*' : '**'}}</td>
                <td>{{$value->monthly}} {{env('CURRENCY')}}</td>
                <td>{{$value->annual}} {{env('CURRENCY')}}</td>
              </tr>
              @endif
            @endforeach
          </tbody>
      </table>
    </div>
  </div>
  @endif
@stop
