@set('js', ['src/js/incidence.js'])
@section('title-page', trans('incidence.incidences')." - ".trans('messages.history'))
@section('admin-page-title', trans('incidence.incidences')." - ".trans('messages.history'))
@extends('layouts.main.master')
@section('admin-body')
  @include('sections.messages')
  @if ($incidences->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.incidence.messages')
    <table class="table table-striped table-hover table-responsive" name="icstable" id="icstable">
      <thead>
        <tr>
          <th style="text-align: center">Item</th>
          <th style="text-align: center">{{trans('incidence.status')}}</th>
          <th style="text-align: center">{{trans('incidence.type')}}</th>
          <th style="text-align: center">{{trans('incidence.mode')}}</th>
          <th style="text-align: center">{{trans('incidence.profile')}}</th>
          <th style="text-align: center">{{trans('incidence.client')}}</th>
          <th style="text-align: center">{{trans('incidence.created_at')}}</th>
          <th style="text-align: center">{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($incidences as $key => $value)
          <tr item="{{json_encode($value)}}">
            <td>
                <a class="icslinkdetails" onclick="showIncidence({{$value->id}})">N°{{$key + 1}}</a>
            </td>
            <td>
              @if($value->status == true)
              <span class="label label-success">{{trans('incidence.Resolve')}}</span>
              @else
              <span class="label label-danger">{{trans('incidence.noresolve')}}</span>
              @endif
            </td>
            @if($value->type == 0)
            <td>{{trans('incidence.incidence')}} <i class="fa fa-question-circle-o fa-fw" aria-hidden="true"></i></td>
            @else
            <td>{{trans('incidence.error')}} <i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i></td>
            @endif
            <td>{{$value->contract == null ? trans('incidence.test') : trans('incidence.contract')}}</td>
            <td>{{$value->profile}}</td>
            <td>{{$value->name}}</td>
            <td>{{$value->created_at}}</td>
            <td>
              <ul class="table-actions">
                <li><a onclick="incidenceDelete($(this))" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
                <li><a href="{{asset("admin/incidences/{$value->id}")}}/mail"><i class="fa fa-envelope-o" aria-hidden="true" title="{{trans('messages.email')}}"></i></a></li>
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@stop
