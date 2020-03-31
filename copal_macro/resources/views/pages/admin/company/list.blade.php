@set('js', ['js/includes/companyCtrl.js'])
@section('pageTitle', trans('company.list'))
@section('title', trans('company.list'))
@extends('pages.page')
@section('title-actions')
<a href="{{asset('admin/company/new')}}" class="btn btn-primary" title="{{trans('company.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.company.messages')
  @include('sections.messages')
  <div class="panel panel-default cp" id = "pnlin">
  <div class="panel-body">
    <table class="table table-striped table-hover text-center" id="dtble">
      <thead>
        <tr>
          <th>{{trans('messages.code')}}</th>
          <th>{{trans('messages.name')}}</th>
          <th>{{trans('messages.phone')}}</th>
          <th>{{trans('company.created_at')}}</th>
          <th>{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($companys as $company)
          <tr item="{{$company->toInnerJson()}}">
            <td><a class = "infoRd" id="{{$company->id}}" href ="javascript:details({{$company->id}})">{{$company->code}}</a></td>
            <td>{{$company->name}}</td>
            <td>{{$company->phone_01}}</td>
            <td>{{$company->created_at->format('Y-m-d')}}</td>
            <td>
              <ul class="table-actions">
                <li><a onclick="companyDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop
