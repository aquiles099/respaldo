@set('js', ['src/js/contract.js'])
@section('title-page', trans('menu.clients'))
@section('admin-page-title', trans('menu.clients'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('admin-body')
    @include('sections.messages')
  @if ($contracts->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.contract.messages')
  <table class="table table-striped table-hover table-responsive" name="icstable" id="icstable">
    <thead>
      <tr>
        <th style="text-align: center">{{trans('contract.code')}}</th>
        <th style="text-align: center">{{trans('contract.status')}}</th>
        <th style="text-align: center">{{trans('contract.client')}}</th>
        <th style="text-align: center">{{trans('contract.register')}}</th>
        <th style="text-align: center">{{trans('contract.cutoff_date')}}</th>
        <th style="text-align: center">{{trans('messages.actions')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($contracts as $key => $value)
        <tr item="{{json_encode($value)}}">
          <td style="text-align:center">
            <a class="icslinkdetails" onclick="showContract({{$value->id}})">{{$value->code}}</a>
          </td>
          <td style="text-align:center">
            @if($value->status == App\Helpers\HStatus::ACTIVE)<span class="label label-success">{{$value->getStatus['name']}}</span>@endif
            @if($value->status == App\Helpers\HStatus::INACTIVE)<span class="label label-danger">{{$value->getStatus['name']}}</span>@endif
            @if($value->status == App\Helpers\HStatus::WARNING)<span class="label label-warning">{{$value->getStatus['name']}}</span>@endif
            @if($value->status == App\Helpers\HStatus::DEFEATED)<span class="label label-default">{{$value->getStatus['name']}}</span>@endif
            @if($value->status == App\Helpers\HStatus::EXTENDED)<span class="label label-primary">{{$value->getStatus['name']}}</span>@endif
          </td>
          <td style="text-align:center">
            {{isset($value->getSolicitude->getClient->name) ? strtoupper($value->getSolicitude->getClient->name) : trans('messages.unknown')}}
            {{isset($value->getSolicitude->getClient->webpage) ? $value->getSolicitude->getClient->webpage : '' }}
          </td>
          <td style="text-align:center">{{$value->created_at}}</td>
          <td style="text-align:center">{{$value->cut_off_date}} </td>
          <td style="text-align:center">
            <ul class="table-actions">
              <li><a onclick="contractDelete($(this))" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
              <li><a href="{{asset("admin/contracts/{$value->id}")}}/mail"><i class="fa fa-envelope-o" aria-hidden="true" title="{{trans('messages.email')}}"></i></a></li>
              <li><a href="{{asset("admin/contracts/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
              <li><a href="{{asset("admin/contracts/{$value->id}")}}/contract" target="_blank"><i class="fa fa-file-pdf-o" title="{{trans('messages.export')}}"></i></a></li>
              {{--<li><a href="{{asset("admin/contracts/{$value->id}")}}/payments" target="_blank"><i class="fa fa-money" title="{{trans('messages.payments')}}"></i></a></li>--}}
              <!-- Se verifica si existen incidencias reportadas sin resolver-->
              @if($value->verifyIncidence($value->id) > 0)
              <li>
                <a href="{{asset("admin/contracts/{$value->id}")}}/incidences">
                  <i class="fa fa-question-circle-o animated infinite shake" aria-hidden="true" title="{{$value->verifyIncidence($value->id)}} {{trans('test.newincidences')}}"></i>
                </a>
              </li>
              @endif
              <!-- Se verifica si existen errores reportados sin resolver-->
              @if($value->verifyBug($value->id) > 0)
              <li>
                <a href="{{asset("admin/contracts/{$value->id}")}}/bugs">
                  <i class="fa fa-exclamation-triangle animated infinite shake" aria-hidden="true" title="{{$value->verifyBug($value->id)}} {{trans('test.newbugs')}}">
                  </i>
                </a>
              </li>
              @endif
            </ul>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif
@stop
