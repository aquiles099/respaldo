@set('js', ['src/js/contact.js'])
@section('title-page', trans('contact.webcontacts'))
@section('admin-page-title', trans('contact.webcontacts'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('admin-body')
  @include('sections.messages')
  @if ($contacts->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.contact.messages')

  <table class="table table-striped table-responsive table-hover" name="icstable" id="icstable">
    <thead>
      <tr>
        <th>{{trans('contact.code')}}</th>
        <th>{{trans('contact.name')}}</th>
        <th>{{trans('contact.subject')}}</th>
        <th>{{trans('contact.created_at')}}</th>
        <th>{{trans('messages.actions')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($contacts as $key => $value)
        <tr item="{{json_encode($value)}}">
          <td>
            <a class="icslinkdetails" onclick="icsDetails({{$value->id}}, false)">{{$value->code}}</a>
          </td>
          <td>{{$value->name}}</td>
          <td>{{$value->subject}}</td>
          <td>{{$value->created_at}}</td>
          <td>
            <ul class="table-actions">
              <li><a onclick="contactDelete($(this))"><i class="fa fa-times" title="{{trans('messages.delete')}}"></i></a></li>
              @if($value->answered == NULL)
                <li><a href="{{asset("admin/contacts/{$value->id}")}}/mail"><i class="fa fa-envelope-o" aria-hidden="true" title="{{trans('messages.email')}}"></i></a></li>
              @else
              <li><i class="fa fa-envelope-open-o" aria-hidden="true" title="{{trans('messages.readed')}}"></i><strong> Respondido</strong></li>
              @endif
            </ul>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif
@stop
