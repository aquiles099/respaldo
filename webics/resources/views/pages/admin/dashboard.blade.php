@section('title-page', trans('messages.dashboard'))
@section('admin-page-title', trans('messages.dashboard'))
@extends('layouts.main.master')
@section('admin-body')
@include('sections.messages')
<div class="col-md-3">
	<div class="panel panel-default">
		<div class="panel-body">
			<h1>
				<i class="fa fa-user fa-fw"></i>
				<span class="pull-right">{{$clients->count()}}</span>
			</h1>
		</div>
		<a href="{{asset('/admin/clients')}}">
			<div class="panel-footer">
				{{trans('menu.clients')}}
			</div>
		</a>
	</div>
</div>
<div class="col-md-3">
	<div class="panel panel-default">
		<div class="panel-body">
			<h1>
				<i class="fa fa-bullhorn fa-fw"></i>
				<span class="pull-right">{{$solicitudes->count()}}</span>
			</h1>
		</div>
		<a href="{{asset('/admin/solicitudes')}}">
			<div class="panel-footer">
				{{trans('menu.solicitudes')}}
			</div>
		</a>
	</div>
</div>
@if(Session::get('key-sesion')['type'] == App\Helpers\HUserType::MASTER)
<div class="col-md-3">
	<div class="panel panel-default">
		<div class="panel-body">
			<h1>
				<i class="fa fa-handshake-o fa-fw"></i>
					<span class="pull-right">{{$contracts->count()}}</span>
			</h1>
		</div>
		<a href="{{asset('/admin/contracts')}}">
			<div class="panel-footer">
				{{trans('menu.contracts')}}
			</div>
		</a>
	</div>
</div>
<div class="col-md-3">
	<div class="panel panel-default">
		<div class="panel-body">
			<h1>
				<i class="fa fa-users fa-fw"></i>
				<span class="pull-right">{{$users->count()}}</span>
			</h1>
		</div>
		<a href="{{asset('/admin/users')}}">
			<div class="panel-footer">
				{{trans('menu.users')}}
			</div>
		</a>
	</div>
</div>
@endif
@stop
