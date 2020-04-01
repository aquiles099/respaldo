@set('js', ['js/includes/promotionsCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('promotion.list'))
@section('title', trans('promotion.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/promotions/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('promotion.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.promotions.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table table-striped table-hover" id="dtble_promotion">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('promotion.name')}}</th>
            <th>{{trans('promotion.startDate')}}</th>
            <th>{{trans('promotion.endDate')}}</th>
            <th>{{trans('promotion.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($promotions as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td>{{$row->code}}</td>
              <td>{{$row->name}}</td>
              <td>{{$row->start_date}}</td>
              <td>{{$row->end_date}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="promotionsDelete($(this))"><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("/admin/promotions/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("/admin/promotions/{$row->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
