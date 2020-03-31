@set('js', ['src/js/cargoReleaseCtrl.js'])
@section('pageTitle', trans('cargoRelease.list'))
@section('title', trans('cargoRelease.list'))
@extends('pages.page')
@section('title-actions')
<a href="{{asset('admin/cargoRelease/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" data-toggle ="tooltip" title="{{trans('cargoRelease.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
@include('pages.admin.cargoRelease.messages')
@include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-bordeared table-responsive text-center" id="dtble">
        <thead>
          <th>{{trans('cargoRelease.status')}}</th>
          <th>{{trans('cargoRelease.code')}}</th>
          <th>{{trans('cargoRelease.releaseDate')}}</th>
          <th>{{trans('cargoRelease.releaseTime')}}</th>
          <th>{{trans('cargoRelease.releaseTo')}}</th>
          <th>{{trans('cargoRelease.pieces')}}</th>
          <th>{{trans('cargoRelease.weight')}}</th>
          <th>{{trans('cargoRelease.volume')}}</th>
          <th>{{trans('cargoRelease.actions')}}</th>
        </thead>
        <tbody>
          @foreach($cargo_release as $key => $value)
            <tr item="{{$value->toInnerJson()}}">
              <td>
                @if($value->last_event == '1')
                  <span class="label label-default">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '2')
                  <span class="label label-primary">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '3')
                  <span class="label label-info">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '4')
                  <span class="label label-info">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '5')
                  <span class="label label-warning">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '6')
                  <span class="label label-success">{{$value->getLastEvent->name}}</span>
                @endif
              </td>
              <td><a href="javascript:icsGetDetailCargoRelease({{$value->id}})" class="infoRd">{{$value->code}}</a></td>
              <td>{{$value->release_date}}</td>
              <td>{{$value->release_time}}</td>
              <td><a href="javascript:icsShowCargoContaInfo({{$value->id}})" class="infoRd">{{$value->contact_name}}</a></td>
              <td>{{$value->getCargoCount()}}</td>
              <td>{{$value->getTotalWeightCargoRelease()}}</td>
              <td>{{$value->getTotalVolumeCargoRelease()}}</td>
              <td>
                <ul class="table-actions">
                  <li><a href="{{asset("/admin/cargoRelease/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a onclick="cargoReleaseDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                  {{--<li><a href="javascript:" ><i class="fa fa-file-pdf-o" title="{{trans('cargoRelease.cargoReleaseReport')}}"></i></a></li>--}}
                  {{--<li><a href="javascript:icsBillOfLading({{$value->id}})" ><i class="fa fa-file-pdf-o" title="{{trans('cargoRelease.billOfLadingReport')}}"></i></a></li>--}}
                  <li>
                      <div class="dropdown" >
                        <a class="dropdown-toggle" type="button" data-toggle="dropdown">
                          <span data-toggle="tooltip" title="{{trans('booking.reports')}}">
                            <i class="fa fa-file-pdf-o"  aria-hidden="true"></i>
                          </span>
                        </a>
                        <ul class="dropdown-menu ics_dropdown_menu_action" id="ics_unordenated_list">
                          <li class="dropdown-header" style="display:block">{{trans('cargoRelease.list')}}</li>
                          <li><a href="{{asset("admin/invoice/{$value->id}/cargoRelease")}}" target="_blank">{{trans('cargoRelease.cargoReleaseReport')}}</a></li>
                        </ul>
                      </div>
                  </li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
