@set('rows', fill($data))
@set('js', ['js/includes/consolidatedCtrl.js'])
@section('pageTitle', trans('consolidated.consolidated'))
@section('title', trans('consolidated.consolidated'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/consolidated/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('consolidated.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.consolidated.messages')
  @include('sections.messages')
  <div class="panel panel-default showconsolidatedd" id = "pnlin">
    <div class="panel-body ">
      <table class="table table-striped table-hover" id="dtble_pickup">
        <thead>
          <tr>
            <th style="text-align: center">{{trans('messages.code')}}</th>
            <th style="text-align: center">{{trans('consolidated.status')}}</th>
            <th style="text-align: center">{{trans('messages.description')}}</th>
            <th style="text-align: center">{{trans('messages.observation')}}</th>
            <th style="text-align: center">{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rows[0] as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:detailsconsolidate({{$row->id}},'true')">{{$row->code}}</a></td>
              <td>{{$row->getLastEvent->description}}</td>
              <td>{{$row->description}}</td>
              <td>{{$row->observation}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="consolidatedDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  @if($row->last_event <= 5 )
                   <li><a href="{{asset("admin/consolidated/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  @endif
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
