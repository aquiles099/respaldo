@set('js', ['js/includes/taxCtrl.js'])
@include('sections.translate')
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
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table table-striped" id="dtble_tax">
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
          @foreach ($taxes as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td>{{$row->code}}</td>
              <td>{{$row->name}}</td>
              <td>{{$row->type === 0 ? trans('messages.percentage') : trans('messages.fix') }}</td>
              <td>{{$row->value}}</td>
              <td>{{$row->state == 1 ? trans('messages.active') : trans('messages.inactive') }}</td>
              <td>{{$row->getCountry->name}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="taxDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("admin/tax/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("admin/tax/{$row->id}")}}/read"><i class="fa fa-eye"    title="{{trans('messages.details')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
