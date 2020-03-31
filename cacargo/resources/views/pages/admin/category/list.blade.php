@set('js', ['js/includes/categoryCtrl.js'])
@section('pageTitle', trans('category.list'))
@section('title', trans('category.list'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/category/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('category.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.category.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover" id="dtble">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.percentage')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td><a class = "infoRd" href = "javascript:details({{$row->id}})">{{$row->code}}</a></td>
              <td style="text-transform:capitalize;">{{$row->label}}</td>
              <td>{{$row->percentage}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="categoryDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@stop
