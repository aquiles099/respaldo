@set('js', ['src/js/solicitude.js'])
@section('title-page', trans('solicitude.testsolicitudes'))
@section('admin-page-title', trans('solicitude.testsolicitudes'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/solicitudes/new')}}" class="btn btn-primary" title="{{trans('solicitude.new')}}">
  <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
  {{trans('solicitude.new')}}
</a>
@stop
@section('admin-body')
  @if ($solicitudes->count() == 0)
    @include('sections.no-rows')
  @else
  @include('sections.messages')
  @include('pages.admin.solicitude.messages')
  <table class="table table-striped table-hover table-responsive" name="icstable" id="icstable">
    <thead>
      <tr>
        <th style="text-align: center">{{trans('solicitude.code')}}</th>
        <th style="text-align: center">{{trans('solicitude.status')}}</th>
        <th style="text-align: center">{{trans('solicitude.subject')}}</th>
        <th style="text-align: center">{{trans('solicitude.client')}}</th>
        <th style="text-align: center">{{trans('solicitude.profile')}}</th>
        <th style="text-align: center">{{trans('solicitude.created_at')}}</th>
        <th style="text-align: center">{{trans('messages.actions')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($solicitudes as $key => $value)
        <tr item="{{json_encode($value)}}">
          <td>
            <a class="icslinkdetails" onclick="icsDetails({{$value->id}}, false)">{{$value->code}}</a>
          </td>
          <!--Estado-->
          <td>
            @if($value->status == App\Helpers\HStatus::GENERATED)<span class="label label-default">{{$value->getStatus['name']}}</span>@endif
            @if($value->status == App\Helpers\HStatus::FORMSENDED)<span class="label label-warning">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
            @if($value->status == App\Helpers\HStatus::FORMRECEIVED)<span class="label label-primary">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
            @if($value->status == App\Helpers\HStatus::ONCOURSE)<span class="label label-primary">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
            @if($value->status == App\Helpers\HStatus::PROCESED)<span class="label label-primary">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
            @if($value->status == App\Helpers\HStatus::APROVED)<span class="label label-success">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
            @if($value->status == App\Helpers\HStatus::DENIED)<span class="label label-danger">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
          </td>
          <td>{{$value->subject}}</td>
          <td>{{isset($value->getClient->email) ? $value->getClient->email : trans('messages.unknown')}}</td>
          <td>
            @if ($value->profile == '1')
              {{trans('messages.micro')}}
            @elseif ($value->profile == '2')
              {{trans('messages.macro')}}
              @else
              {{trans('messages.unknown')}}
            @endif
          </td>
          <td>{{$value->created_at}}</td>
          <td>
            <ul class="table-actions">
              <li><a onclick="solicitudeDelete($(this))"><i class="fa fa-times fa-fw"  title="{{trans('messages.delete')}}"></i></a></li>
              <li><a href="{{asset("admin/solicitudes/{$value->id}")}}/mail"><i class="fa fa-envelope-o" aria-hidden="true" title="{{trans('messages.email')}}"></i></a></li>
              @if($value->status == App\Helpers\HStatus::APROVED)
                @if($value->verifyTest($value->id) == 0)
                <li><a onclick="icsDoContract($(this))" id="icsLinkContrac-{{$value->id}}"><i class="fa fa-search fa-fw"  title="{{trans('messages.dotest')}}"></i></a></li>
                @else
                <li><i class="fa fa-search fa-fw"  title="{{trans('messages.tested')}}"></i></li>
                @endif
              @endif
            </ul>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif
@stop
