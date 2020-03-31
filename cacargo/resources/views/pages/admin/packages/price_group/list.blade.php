@set('rows', fill($data))
@set('js', ['js/includes/priceGroupCtrl.js'])
@section('pageTitle', trans('price_group.list'))
@section('title', trans('price_group.list'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <div class="row" style="display:table-caption;margin-left:0px;width:300px">
      <div class="col-lg-12" style="padding-left:0px;padding-right:0px;">
        <div class="input-group">
          <input onchange="searchCompany()" id="search" type="text" class="form-control" placeholder="{{trans('messages.search')}}">
          <span class="input-group-btn">
            <button onclick="searchCompany()" class="btn btn-default" type="button" title="{{trans('messages.search')}}">
              <i class="fa fa-search"></i>
            </button>
            <a href="{{asset('admin/price_group/new')}}" class="btn btn-default" title="{{trans('company.create')}}">
              <i class="fa fa-plus" aria-hidden="true"></i>
              {{trans('messages.create')}}
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
@stop
@section('body')
  @include('pages.admin.packages.price_group.messages')
  @include('sections.messages')
  <table class="table table-striped">
    <thead>
      <tr>
        <th style="width:20%; text-align:center">{{trans('price_group.interval')}}</th>
        <th style="width:65%">{{trans('price_group.name')}}</th>
        <th style="width:15%">{{trans('messages.actions')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($rows[0] as $row)
        <tr item="{{$row->toInnerJson()}}">
          <td style="text-align:center"> {{htmlentities(sprintf('[%s - %s]', sprintf('%05.2f', $row->min), sprintf('%05.2f', $row->max)))}}</td>
          <td>{{$row->name}}</td>
          <td>
            <ul class="table-actions">
              <li><a onclick="clientDelete($(this))" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
              <li><a href="{{asset("admin/price_groups/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
              <li><a href="{{asset("admin/price_groups//{$row->id}")}}/read"><i class="fa fa-eye"    title="{{trans('messages.details')}}"></i></a></li>
            </ul>
          </td>
        </tr>
      @endforeach
      @foreach ($rows[1] as $row)
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3">
          @include('sections.list.pagination', ['pages' => $data])
        </td>
      </tr>
    </tfoot>
  </table>
@stop
