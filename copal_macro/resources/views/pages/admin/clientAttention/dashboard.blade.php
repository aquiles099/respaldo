@section('pageTitle', trans('clientAttention.clientAttention'))
@section('title', trans('clientAttention.clientAttention'))
@extends('pages.page')
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
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention/categories')}}"><i class="fa fa-briefcase" aria-hidden="true"></i> {{trans('clientAttention.categories')}}</a></li>
            <li class="user-menu-item"><a href="{{asset('admin/clientAttention/companies')}}"><i class="fa fa-briefcase" aria-hidden="true"></i> {{trans('clientAttention.companys')}}</a></li>
          </ul>
      </div>
  </div>
@stop
@section('body')
  @include('sections.messages')
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading"><h4>{{trans('clientAttention.packages')}}</h4><div class="timeline-badge"><i class="fa fa-cube"></i></div></div>
        <a href="{{asset('admin/clientAttention/packages')}}">
          <div class="panel-footer">
            {{trans('clientAttention.searchPackages')}}
            <span class="pull-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
          </div>
        </a>
     </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-green">
        <div class="panel-heading"><h4>{{trans('clientAttention.users')}}</h4><div class="timeline-badge"><i class="fa fa-user"></i></div></div>
        <a href="{{asset('admin/clientAttention/users')}}">
          <div class="panel-footer">
            {{trans('clientAttention.searchUsers')}}
            <span class="pull-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
          </div>
        </a>
     </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-yellow">
        <div class="panel-heading"><h4>{{trans('clientAttention.promotions')}}</h4><div class="timeline-badge"><i class="fa fa-star"></i></div></div>
        <a href="{{asset('admin/clientAttention/promotions')}}">
          <div class="panel-footer">
            {{trans('clientAttention.searchPromotions')}}
            <span class="pull-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
          </div>
        </a>
     </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-red">
        <div class="panel-heading"><h4>{{trans('clientAttention.taxes')}}</h4><div class="timeline-badge"><i class="fa fa-money"></i></div></div>
        <a href="{{asset('admin/clientAttention/taxes')}}">
          <div class="panel-footer">
            {{trans('clientAttention.searchTaxes')}}
            <span class="pull-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
          </div>
        </a>
     </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default" id="pnldelv">
        <div class="panel-heading"><h4>{{trans('clientAttention.services')}}</h4><div class="timeline-badge"><i class="fa fa-random"></i></div></div>
        <a href="{{asset('admin/clientAttention/services')}}">
          <div class="panel-footer">
            {{trans('clientAttention.searchServices')}}
            <span class="pull-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
          </div>
        </a>
     </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default" id="pnlnoin">
        <div class="panel-heading"><h4>{{trans('clientAttention.categories')}}</h4><div class="timeline-badge"><i class="fa fa-table"></i></div></div>
        <a href="{{asset('admin/clientAttention/categories')}}">
          <div class="panel-footer">
            {{trans('clientAttention.searchCategories')}}
            <span class="pull-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
          </div>
        </a>
     </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default" id="pnlnocp">
        <div class="panel-heading"><h4>{{trans('clientAttention.companys')}}</h4><div class="timeline-badge"><i class="fa fa-briefcase"></i></div></div>
        <a href="{{asset('admin/clientAttention/companies')}}">
          <div class="panel-footer">
            {{trans('clientAttention.searchCompanys')}}
            <span class="pull-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
          </div>
        </a>
     </div>
    </div>
  </div>

@stop
