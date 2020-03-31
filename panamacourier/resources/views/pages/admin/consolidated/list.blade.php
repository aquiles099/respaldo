@set('js', ['js/includes/consolidatedCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('consolidated.consolidated'))
@section('title', trans('consolidated.consolidated'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/consolidated/new')}}" class="btn btn-primary" title="{{trans('consolidated.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.consolidated.messages')
  @include('sections.messages')
  <div class="panel panel-default showconsolidatedd" id = "pnlin">
    <div class="panel-body ">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th style="width:15%">{{trans('messages.code')}}</th>
            <th style="width:30%">{{trans('messages.description')}}</th>
            <th style="width:40%">{{trans('messages.observation')}}</th>
            <th style="width:30%">{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($consolidates as $consolidate)
            <tr item="{{$consolidate->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:detailsconsolidate({{$consolidate->id}},'true')">{{$consolidate->code}}</a></td>
              <td>{{$consolidate->description}}</td>
              <td>{{$consolidate->observation}}</td>
              <td>
                <ul class="table-actions">
                  <li><a href="{{asset("admin/consolidated/{$consolidate->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="javascript:detailsconsolidate({{$consolidate->id}})"><i class="fa fa-info-circle"    title="{{trans('messages.showconsolidated')}}"></i></a>
                  <li><a onclick="consolidatedDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
