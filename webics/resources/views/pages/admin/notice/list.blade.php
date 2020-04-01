@set('js', ['src/js/notice.js'])
@section('title-page', trans('notice.notices'))
@section('admin-page-title', trans('notice.notices'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/notices/new')}}" class="btn btn-primary" title="{{trans('notice.new')}}">
  <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
  {{trans('notice.new')}}
</a>
@stop
@section('admin-body')
  @include('sections.messages')
  @if ($notices->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.notice.messages')
    <table class="table table-striped table-hover table-responsive" name="icstable" id="icstable">
      <thead>
        <tr>
          <th style="text-align: center">{{trans('notice.code')}}</th>
          <th style="text-align: center">{{trans('notice.status')}}</th>
          <th style="text-align: center">{{trans('notice.title')}}</th>
          <th style="text-align: center">{{trans('notice.postedby')}}</th>
          <th style="text-align: center">{{trans('notice.created_at')}}</th>
          <th style="text-align: center">{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($notices as $key => $value)
          <tr item="{{json_encode($value)}}">
            <td>
              {{$value->code}}
            </td>
            <td><span class="label label-{{is_null($value->published) || $value->published == false ? 'danger' : 'success' }}">{{is_null($value->published) || $value->published == false ? trans('notice.nopublished') : trans('notice.published') }}</span></td>
            <td>{{$value->title}}</td>
            <td>{{isset($value->getAdmin->code) ? $value->getAdmin->code : ''}} {{isset($value->getAdmin->name) ? $value->getAdmin->name : ''}}</td>
            <td>{{$value->created_at}}</td>
            <td>
              <ul class="table-actions">
                <li><a href="{{asset("admin/notices/{$value->id}")}}/check" target="_blank"><i class="fa fa-eye fa-fw" title="{{trans('messages.view')}}"></i></a></li>
                @if($value->published != true)
                  <li><a href="{{asset("admin/notices/{$value->id}")}}/aproved"><i class="fa fa-check fa-fw" title="{{trans('messages.aproved')}}"></i></a></li>
                @endif
                <li><a href="{{asset("admin/notices/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                <li><a onclick="noticeDelete($(this))" ><i class="fa fa-times fa-fw"  title="{{trans('messages.delete')}}"></i></a></li>
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@stop
