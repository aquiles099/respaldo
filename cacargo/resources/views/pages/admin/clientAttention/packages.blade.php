@set('js', ['js/includes/clientAttentionCtrl.js'])
@section('pageTitle', trans('clientAttention.searchPackages'))
@section('title', trans('clientAttention.searchPackages'))
@extends('pages.page')
@include('sections.translate')
@section('title-actions')
@stop
@section('pre-title')
  <div class="row">
      <div class="col-lg-12 border-bottom">
          <ul class="nav navbar-top-links in user-menu">
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention')}}"><i class="fa fa-home" aria-hidden="true"></i>  {{trans('clientAttention.start')}}</a></li>
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention/packages')}}"><i class="fa fa-cube" aria-hidden="true"></i>  {{trans('clientAttention.packages')}}</a></li>
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention/users')}}"><i class="fa fa-user" aria-hidden="true"></i> {{trans('clientAttention.users')}}</a></li>
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention/promotions')}}"><i class="fa fa-star" aria-hidden="true"></i> {{trans('clientAttention.promotions')}}</a></li>
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention/taxes')}}"><i class="fa fa-money" aria-hidden="true"></i> {{trans('clientAttention.taxes')}}</a></li>
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention/services')}}"><i class="fa fa-random" aria-hidden="true"></i> {{trans('clientAttention.services')}}</a></li>
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention/categories')}}"><i class="fa fa-table" aria-hidden="true"></i> {{trans('clientAttention.categories')}}</a></li>
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention/companies')}}"><i class="fa fa-briefcase" aria-hidden="true"></i> {{trans('clientAttention.companys')}}</a></li>
          </ul>
      </div>
  </div>
@stop
@section('body')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive" id="dtble">
        <thead>
          <tr>
            <th>{{trans('messages.tracking')}}</th>
            <th>{{trans('messages.type')}}</th>
            <th>{{trans('messages.category')}}</th>
            <th>{{trans('messages.invoice')}}</th>
            <th>{{trans('package.registred')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($packages as $package)
            <tr>
              <td><a class="infoRd" href="javascript:detailspackage('{{$package->id}}')">{{$package->tracking}}</a></td>
              <td>@if($package->getType) {{$package->getType->spanish}} @endif</td>
              <td>@if($package->getCategory) {{$package->getCategory->label}} @endif</td>
              <td>@if($package->invoice == 0)<i class="fa fa-times" aria-hidden="true"></i>@else<i class="fa fa-check" aria-hidden="true"></i>@endif</td>
              <td>{{$package->created_at}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
