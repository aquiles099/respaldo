@set('js', ['js/includes/companyCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('company.list'))
@section('title', trans('company.list'))
@extends('pages.page')
@section('title-actions')
  <a href="{{asset('admin/company/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('company.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
    {{trans('messages.create')}}
  </a>
@stop
@section('body')
  @include('pages.admin.company.messages')
  @include('sections.messages')
  <div class="panel panel-default cp" id = "pnlin">
  <div class="panel-body">
    <table class="table table-striped table-hover" id="dtble_company">
      <thead>
        <tr>
          <th>{{trans('messages.code')}}</th>
          <th>{{trans('messages.name')}}</th>
          <th>{{trans('messages.phone')}}</th>
          <th>{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($companys as $row)
          <tr item="{{$row->toInnerJson()}}">
            <td style="text-align:center; text-transform:capitalize;"><a class = "infoRd" id = "{{$row->id}}" href = "javascript:details({{$row->id}})">{{$row->code}}</a></td>
            <td style="text-align:center; text-transform:capitalize;">{{$row->name}}</td>
            <td style="text-align:center; text-transform:capitalize;">{{$row->phone_01}}</td>
            <td style="text-align:center; text-transform:capitalize;">
              <ul class="table-actions">
                <li><a onclick="companyDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
      </tfoot>
    </table>
  </div>
</div>
@stop
