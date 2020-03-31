@set('js', ['js/includes/taxCtrl.js'])
@section('pageTitle', trans('tax.taxes'))
@section('title', trans('tax.taxes'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/tax/new')}}" class="btn btn-primary" title="{{trans('tax.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.tax.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.type')}}</th>
            <th>{{trans('messages.value')}}</th>
            <th>{{trans('messages.state')}}</th>
            <th>{{trans('messages.countries')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($taxes as $tax)
            <tr item="{{$tax->toInnerJson()}}">
              <td><a class = "infoRd" href = "javascript:details({{$tax->id}})">{{$tax->code}}</a></td>
              <td>{{ucwords($tax->name)}}</td>
              <td>{{($tax->type == 0) ? trans('tax.percentage') : trans('tax.fix') }}</td>
              <td>{{$tax->value}}</td>
              <td>{{($tax->state == 0) ? trans('tax.inactive')  : trans('tax.active') }}</td>
              <td>{{ucwords($tax->getCountry->name)}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="taxDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
