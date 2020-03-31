@set('js', ['js/includes/addchargeCtrl.js'])
@section('pageTitle', trans('addcharge.addcharges'))
@section('title', trans('addcharge.addcharges'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/addcharge/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('addcharge.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.addcharge.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover" id="dtble">
        <thead>
          <tr>
            <th style="width:20%">{{trans('messages.id')}}</th>
            <th style="width:20%">{{trans('messages.name')}}</th>
            <th style="width:20%">{{trans('messages.description')}}</th>
            <th style="width:20%">{{trans('messages.value')}}</th>
            <th style="width:20%">{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($addcharges as $addcharge)
             <td>{{$addcharge->id}}</td>
              <td>{{$addcharge->name}}</td>
              <td>{{$addcharge->description}}</td>
              <td>{{$addcharge->value}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="officeDelete($(this))" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
