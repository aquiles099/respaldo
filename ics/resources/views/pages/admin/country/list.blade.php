@set('js', ['js/includes/countryCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('country.countries'))
@section('title', trans('country.countries'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/country/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('country.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.country.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
  <div class="panel-body">
    <table class="table table-striped table-hover text-center" id="dtble_country">
      <thead>
        <tr>
          <th>{{trans('messages.code')}}</th>
          <th>{{trans('messages.name')}}</th>
          <th>{{trans('country.created_at')}}</th>
          <th>{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($countrys as $country)
          <tr item="{{$country->toInnerJson()}}">
            <td><a class="infoRd" href="javascript:details({{$country->id}})">{{$country->code}}</a></td>
            <td>{{ucwords($country->name)}}</td>
            <td>{{$country->created_at->format('Y-m-d')}}</td>
            <td>
              <ul class="table-actions">
                <li><a onclick="countryDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop
