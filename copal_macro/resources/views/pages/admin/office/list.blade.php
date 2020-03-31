@set('js', ['js/includes/officeCtrl.js'])
@section('pageTitle', trans('office.offices'))
@section('title', trans('office.offices'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/office/new')}}" class="btn btn-primary" title="{{trans('office.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.office.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.countries')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($offices as $office)
            <tr item="{{$office->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:details({{$office->id}})">{{$office->code}}</a></td>
              <td>{{ucwords($office->name)}}</td>
              <td>{{ucwords($office->getCountry->name)}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="officeDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
