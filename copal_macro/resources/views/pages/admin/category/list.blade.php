@set('js', ['js/includes/categoryCtrl.js'])
@section('pageTitle', trans('category.list'))
@section('title', trans('category.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/category/new')}}" class="btn btn-primary" title="{{trans('category.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.category.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.percentage')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $category)
            <tr item="{{$category->toInnerJson()}}">
              <td><a class = "infoRd" href = "javascript:details({{$category->id}})">{{$category->code}}</a></td>
              <td>{{ucwords($category->label)}}</td>
              <td>{{$category->percentage}}%</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="categoryDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@stop
