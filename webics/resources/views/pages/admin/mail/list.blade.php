@set('js', ['src/js/mail.js'])
@section('title-page', trans('mail.mails'))
@section('admin-page-title', trans('mail.mails'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/mails/new')}}" class="btn btn-primary" title="{{trans('mail.new')}}">
  <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
  {{trans('notice.new')}}
</a>
@stop
@section('admin-body')
  @include('sections.messages')
  @if ($mails->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.mail.messages')
    <table class="table table-striped table-hover table-responsive" name="icstable" id="icstable">
      <thead>
        <tr>
          <th style="text-align: center">Item</th>
          <th style="text-align: center">{{trans('mail.subject')}}</th>
          <th style="text-align: center">{{trans('mail.email')}}</th>
          <th style="text-align: center">{{trans('mail.admin')}}</th>
          <th style="text-align: center">{{trans('mail.created_at')}}</th>
          <th style="text-align: center">{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($mails as $key => $value)
          <tr item="{{json_encode($value)}}">
            <td>{{$key + 1}}</td>
            <td>
              <a class="icslinkdetails" onclick="icsDetails({{$value->id}}, false)">{{$value->subject}}</a>
            </td>
            <td>{{$value->email}}</td>
            <td>{{isset($value->getAdmin->name) ? $value->getAdmin->name : trans('messages.unknown')}}</td>
            <td>{{$value->created_at}}</td>
            <td>
              <ul class="table-actions">
                <li><a onclick="mailDelete($(this))" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@stop
