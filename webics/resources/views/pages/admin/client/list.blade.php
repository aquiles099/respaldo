@set('js', ['src/js/client.js'])
@section('title-page', trans('client.prospects'))
@section('admin-page-title', trans('client.prospects'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/clients/new')}}" class="btn btn-primary" title="{{trans('client.new')}}">
  <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
  {{trans('client.new')}}
</a>
@stop
@section('admin-body')
  @include('sections.messages')
  @if ($clients->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.client.messages')
  <table class="table table-striped table-hover table-responsive" name="icstable" id="icstable">
    <thead>
      <tr>
        <th style="text-align: center">{{trans('client.code')}}</th>
        <th style="text-align: center">{{trans('client.name')}}</th>
        <th style="text-align: center">{{trans('client.email')}}</th>
        <th style="text-align: center">{{trans('client.created_at')}}</th>
        <th style="text-align: center">{{trans('client.country')}}</th>
        <th style="text-align: center">{{trans('messages.actions')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($clients as $key => $value)
        <tr item="{{$value}}">
          <td>
            <a class="icslinkdetails" onclick="icsShowClient({{$value->id}})">{{$value->code}}</a>
          </td>
          <td>{{$value->name}}</td>
          <td>{{$value->email}}</td>
          <td>{{$value->created_at}}</td>
          <td>{{isset($value->getCountry->name) ? $value->getCountry->name : '' }}</td>
          <td>
            <ul class="table-actions">
              <li><a onclick="clientDelete($(this))" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
              <li>
                <a href="{{asset("admin/clients/{$value->id}")}}">
                  <i class="fa fa-pencil" title="{{trans('messages.edit')}}">
                    @if(!isset($value->dni)) <sup><i class="fa fa-exclamation" aria-hidden="true"></i></sup> @endif
                  </i>
                </a>
                </li>
              <li><a href="{{asset("admin/clients/{$value->id}")}}/mail"><i class="fa fa-envelope-o" aria-hidden="true" title="{{trans('messages.email')}}"></i></a></li>
            </ul>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif
@stop
