@set('js', ['src/js/incidence.js'])
@section('title-page', trans('incidence.incidences')." - ".$contract->code)
@section('admin-page-title', trans('incidence.incidences')." - ".$contract->code)
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/incidences')}}" class="btn btn-primary" title="{{trans('user.new')}}">
  <i class="fa fa-list fa-fw" aria-hidden="true"></i>
  {{trans('incidence.all')}}
</a>
@stop
@section('admin-body')
  @include('sections.messages')
  @if ($incidences->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.test.messages')
    <!--Not Resolve-->
    <div class="fieldset" id="incidenceSection">
      @foreach($incidences as $key => $value)
        <div class="panel panel-warning icsboxshadow" id='icscontain{{$value->id}}'>
          <div class="panel-heading">
            <i class="fa fa-question-circle-o" aria-hidden="true"></i>
            {{$value->subject}}
            <span class="pull-right">
              <a href="{{asset("admin/incidences/{$value->id}")}}/mail" class="icslinkdetails">
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                {{trans('messages.toanswer')}}
              </a>
              |
              <a class="icslinkdetails" onclick="icsResolveIncidence({{$value->id}}, 'icspanelbody{{$value->id}}', 'icscontain{{$value->id}}')">
                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                {{trans('messages.toresolve')}}
              </a>
            </span>
          </div>
          <div class="panel-body" id="icspanelbody{{$value->id}}">
            <!---->
            <p>
              <i class="fa fa-user fa-fw" aria-hidden="true"></i>
              {{trans('messages.client')}}:
              <h5>
                @if(isset($client))
                  <a href="{{asset("admin/clients/{$client->id}")}}" class="icstitle">{{strtoupper($client->name)}}</a>
                @endif
              </h5>
            </p>
            <!--Description-->
            <p>
              <i class="fa fa-commenting-o" aria-hidden="true"></i>
              {{trans('messages.content')}}:
            </p>
            <p class="icsjustify">
              <h3>
                {{$value->description}}
              </h3>
            </p>
            <!--End Description-->
            <!--Image-->
            <p>
              <i class="fa fa-picture-o" aria-hidden="true"></i>
              {{trans('messages.image')}}:
            </p>
            <p>
              <img class="img-thumbnail" src="{{$value->img}}" alt="" />
            </p>
            <!--End Image-->
          </div>
          <div class="panel-footer">
            <strong>{{strtoupper(trans('messages.received'))}}:</strong>
            {{$value->created_at}}
          </div>
        </div>
      @endforeach
    </div>
  @endif
    <!-- All Incidence -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-list fa-fw" aria-hidden="true"></i>
        {{trans('incidence.all')}}
      </div>
      <div class="panel-body">
        <fieldset>
          <table class="table table-striped table-hover table-responsive" name="icstable" id="icstable">
            <thead>
              <tr>
                <th style="text-align: center">{{trans('incidence.subject')}}</th>
                <th style="text-align: center">{{trans('incidence.status')}}</th>
                <th style="text-align: center">{{trans('incidence.resolvedby')}}</th>
                <th style="text-align: center">{{trans('incidence.answer')}}</th>
                <th style="text-align: center">{{trans('incidence.profile')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($allIncidences as $key => $value)
                <tr item="json_encode($value)">
                  <td style="text-align: center">{{$value->subject}}</td>
                  <td style="text-align: center">
                    @if($value->status == true)
                    <span class="label label-success">{{trans('incidence.Resolve')}}</span>
                    @else
                    <span class="label label-danger">{{trans('incidence.noresolve')}}</span>
                    @endif
                  </td>
                  <td style="text-align: center">{{$value->getAdmin['name'] == null ? trans('incidence.none') : $value->getAdmin['name']}}</td>
                  <td style="text-align: center">{{$value->asnwer  == null ? trans('incidence.notanswer') : $value->asnwer }}</td>
                  <td style="text-align: center">{{$value->profile}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </fieldset>
      </div>
    </div>
@stop
