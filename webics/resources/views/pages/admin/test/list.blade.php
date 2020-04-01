@set('js', ['src/js/test.js'])
@section('title-page', trans('test.tests'))
@section('admin-page-title', trans('test.tests'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('admin-body')
  @include('sections.messages')
  @if ($tests->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.test.messages')
    <div class="">
      <table class="table table-striped table-responsive table-hover" name="icstable" id="icstable">
        <thead>
          <tr>
            <th>{{trans('test.code')}}</th>
            <th>{{trans('test.status')}}</th>
            <th>{{trans('test.client')}}</th>
            <th>{{trans('test.profile')}}</th>
            <th>{{trans('test.created_at')}}</th>
            <th>{{trans('test.conditions')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tests as $key => $value)
            <tr item="{{json_encode($value)}}">
              <!--Codigo-->
              <td>
                  <a class="icslinkdetails" onclick="icsDetails({{$value->id}}, false)">{{$value->code}}</a>
              </td>
              <!--Estado-->
              <td>
                @if($value->status == App\Helpers\HStatus::ACTIVE)<span class="label label-success">{{$value->getStatus['name']}}</span>@endif
                @if($value->status == App\Helpers\HStatus::INACTIVE)<span class="label label-danger">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
                @if($value->status == App\Helpers\HStatus::WARNING)<span class="label label-warning">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
                @if($value->status == App\Helpers\HStatus::DEFEATED)<span class="label label-default">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
                @if($value->status == App\Helpers\HStatus::EXTENDED)<span class="label label-primary">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
              </td>
              <!--Correo del Cliente-->
              <td>{{isset($value->getClient->email) ? $value->getClient->email : ''}}</td>
              <!--Perfil Requerido-->
              <td>
                @if(isset($value->getSolicitude))
                  @if ($value->getSolicitude->profile == '1')
                    {{trans('messages.micro')}}
                  @elseif ($value->getSolicitude->profile == '2')
                    {{trans('messages.macro')}}
                    @else
                    {{trans('messages.unknown')}}
                  @endif
                @endif
              </td>
              <!--Fecha de Creacion-->
              <td>{{$value->created_at}}</td>
              <!--Verificar Terminos y Condiciones-->
              <td>
                @if(isset($value->accept_terms))
                  {{trans('test.accepted')}}
                  <i class="fa fa-check fa-fw" aria-hidden="true"></i>
                 @else
                  {{trans('test.noaccept')}}
                  <i class="fa fa-times fa-fw" aria-hidden="true"></i>
                @endif
              </td>
              <!--Acciones-->
              <td>
                <ul class="table-actions">
                  @if(isset($value->accept_terms))
                  <li><a style="font-weight: 900; cursor: pointer" onclick="icsShowTerms({{$value->id}})">TC</a></li>
                  @endif
                  <li><a onclick="testDelete($(this))" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("admin/tests/{$value->id}")}}/mail"><i class="fa fa-envelope-o" aria-hidden="true" title="{{trans('messages.email')}}"></i></a></li>
                  @if($value->status == App\Helpers\HStatus::ACTIVE )
                    @if($value->verifyContract($value->id) == 0)
                    {{--<li><a onclick="icsTestDoContract($(this))"><i class="fa fa-handshake-o fa-fw" title="{{trans('messages.contract')}}"></i></a></li>--}}
                    @else
                    <li><i class="fa fa-handshake-o fa-fw" title="{{trans('messages.contrated')}}"></i></li>
                    @endif
                  @endif
                  <!-- Se verifica si existen incidencias reportadas sin resolver-->
                  @if($value->verifyIncidence($value->id) > 0)
                  <li>
                    <a href="{{asset("admin/tests/{$value->id}")}}/incidences">
                      <i class="fa fa-question-circle-o animated infinite shake" aria-hidden="true" title="{{$value->verifyIncidence($value->id)}} {{trans('test.newincidences')}}"></i>
                    </a>
                  </li>
                  @endif
                  <!-- Se verifica si existen errores reportados sin resolver-->
                  @if($value->verifyBug($value->id) > 0)
                  <li>
                    <a href="{{asset("admin/tests/{$value->id}")}}/bugs">
                      <i class="fa fa-exclamation-triangle animated infinite shake" aria-hidden="true" title="{{$value->verifyBug($value->id)}} {{trans('test.newbugs')}}">
                      </i>
                    </a>
                  </li>
                  @endif
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@stop
