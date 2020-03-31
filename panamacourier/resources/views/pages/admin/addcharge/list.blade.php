@set('js', ['js/includes/addchargeCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('addcharge.addcharges'))
@section('title', trans('addcharge.addcharges'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/addcharge/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('addcharge.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.addcharge.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover" id="dtble">
        <thead>
          <tr><center>
            <th style="text-align: center">{{trans('messages.id')}}</th>
            <th style="text-align: center">{{trans('messages.name')}}</th>
            <th style="text-align: center">{{trans('messages.description')}}</th>
            <th style="text-align: center">{{trans('messages.value')}}($)</th>
            <th style="text-align: center">{{trans('messages.actions')}}</th>  </center>
          </tr>
        </thead>
        <tbody style="text-align: center;">
          @foreach ($addcharges as $addcharge)
            <tr item="{{$addcharge}}">
              <td>{{$addcharge->id}}</td>
              <td>{{$addcharge->name}}</td>
              <td>{{$addcharge->description}}</td>
              <td>{{$addcharge->value}}</td>
              <td>
                <center>
                <ul class="table-actions">
                  <li><a onclick="icsAddChargesDelete({{$addcharge->id}})" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("/admin/addcharge/{$addcharge->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("/admin/addcharge/{$addcharge->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
                </ul>
                <center>
              </td>
              </center>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
