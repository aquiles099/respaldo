@section('title-page', trans('Solicitudes'))
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
  	<h4>{{trans('Solicitudes')}}</h4>
  	<div class="row">
  		<div class="span12">
        <div class="row">
          <div class="col-md-2">
            <div class="navbar-default sidebar" role="navigation">
              <div class="navbar-collapse collapse sidebar-navbar-collapse">
                <ul class="nav navbar-nav">
                  <li><a href="#">Dashboard</a></li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Clientes <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Empresas</a></li>
                      <li><a href="admin/clients/solicitude">Solicitudes</a></li>
                      <li><a href="#">Vendedores</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Registros</a></li>
                  <li><a href="#">Estadisticas</a></li>
                  <li><a href="#">Salir</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <span class="input-group-btn pull-right" style="margin-right:140px; margin-bottom:10px;">
              <a href="{{asset('contact')}}" class="btn btn-default" title="{{trans('package.create')}}">
                <i class="fa fa-plus" aria-hidden="true"></i>
                {{trans('Crear Nuevo')}}
              </a>
            </span>
            <table class="table table-striped table-hover table-responsive table-bordered">
              <thead>
                <tr>
                  <th style="text-align: center;">{{trans('messages.code')}}</th>
                  <th style="text-align: center;">{{trans('Cliente')}}</th>
                  <th style="text-align: center;">{{trans('messages.email')}}</th>
                  <th style="text-align: center;">{{trans('Solicitud')}}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($solicitudes as $solicitude)
                  <tr item="{{$solicitudes}}">
                    <td><a class="infoRd" href="javascript:details({{$solicitude->id}})">{{$solicitude->code}}</a></td>
                    <td>{{$solicitude->getClient['name']}}</td>
                    <td>{{$solicitude->getClient['email']}}</td>
                    <td>{{$solicitude->subject}}</td>
                    <td>
                      <ul class="table-actions">
                        <li><a href="admin/clients/{{$solicitude->id}}" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
                        <li><a href=""><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                      </ul>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
