@set('js', ['js/includes/promotionsCtrl.js'])
@section('pageTitle', trans('promotion.list'))
@section('title', trans('promotion.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/promotions/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('promotion.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.promotions.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('promotion.id')}}</th>
            <th>{{trans('promotion.name')}}</th>
            <th>{{trans('promotion.startDate')}}</th>
            <th>{{trans('promotion.endDate')}}</th>
            <th>{{trans('promotion.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($promotions as $promotion)
            <tr item="{{$promotion->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:details({{$promotion->id}})">{{$promotion->code}}</a></td>
              <td>{{ucwords($promotion->name)}}</td>
              <td>{{ucwords($promotion->start_date)}}</td>
              <td>{{ucwords($promotion->end_date)}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="promotionsDelete($(this))"><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
