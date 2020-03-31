@set('rows', fill($data))
@set('js', ['js/includes/packageCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('package.packages'))
@section('title', trans('package.packages'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <div class="row" style="display:table-caption;margin-left:0px;width:300px">
      <div class="col-lg-12" style="padding-left:0px;padding-right:0px;">
        <div class="input-group">
          <input onchange="searchPackage()" id="search" type="text" class="form-control" placeholder="{{trans('messages.search')}}">
          <span class="input-group-btn">
            <button onclick="searchPackage()" class="btn btn-default" type="button" title="{{trans('messages.search')}}">
              <i class="fa fa-search"></i>
            </button>
            <a href="{{asset('admin/package/new')}}" class="btn btn-default" title="{{trans('package.create')}}">
              <i class="fa fa-plus" aria-hidden="true"></i>
              {{trans('messages')}}
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
@stop
@section('body')
  @include('pages.admin.package.messages')
  @include('sections.messages')
  <div class="panel panel-default showpack" id = "pnlin">
    <div class="panel-body" >
      <table class="table table-striped table-border table-hover text-center">
        <thead>
          <tr>
            <th style="width:15%">{{trans('messages.tracking')}}</th>
            <th style="width:15%">{{trans('messages.type')}}</th>
            <th style="width:15%">{{trans('messages.category')}}</th>
            <th style="width:10%">{{trans('messages.invoice')}}</th>
            <th style="width:15%">{{trans('package.registred')}}</th>
            <th style="width:10%">{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rows[0] as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:detailspackage({{$row->id}}, 'true')">{{$row->tracking}}</a></td>
              <td>{{$row->getType->getName()}}</td>
              <td>{{$row->getCategory->toOption()['text']}}</td>
              <td>@if($row->invoice == 0)<i class="fa fa-times" aria-hidden="true"></i>@else<i class="fa fa-check" aria-hidden="true"></i>@endif</td>
              <td>{{$row->created_at}}</td>
              <td>
                <ul class="table-actions">
                  <li><a href="{{asset("admin/package/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("admin/package/{$row->id}")}}/print" target="_blank"><i class="fa fa-ticket"    title="{{trans('messages.tickets')}}" ></i></a></li>
                  <li><a onclick="packageDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
          @foreach ($rows[1] as $row)
            <tr>
              <td colspan="13">&nbsp;</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="13">
              @include('sections.list.pagination', ['pages' => $data])
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

@stop
