@set('js', ['js/includes/typepickupCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('typepickup.list'))
@section('title', trans('typepickup.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/tpickup/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('typepickup.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.typepickup.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
  <div class="panel-body">
    <table class="table table-striped table-hover table-responsive text-center" id="dtble_pickup_tytpe">
      <thead>
        <tr>
          <th>{{trans('typepickup.code')}}</th>
          <th>{{trans('typepickup.name')}}</th>
          <th>{{trans('typepickup.description')}}</th>
          <th>{{trans('typepickup.actions')}}</th>
        </tr>
      </thead>
      <tbody class="">
        @if(isset($tipepickup))
          @foreach($tipepickup as $key => $value)
            <tr item="{{$value}}">
               <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>

              <td>{{ucwords($value->name)}}</td>
              <td>{{ucwords($value->description)}}</td>
              <td style="text-align:-webkit-center">
                <ul class="table-actions">
                  <!--<li><a href="{{asset("/admin/tpickup/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("/admin/tpickup/{$value->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>-->
                  <li><a onclick="tpickupDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
</div>
@stop
