@include('sections.translate')
@section('pageTitle', trans('messages.messages'))
@section('title', trans('messages.messages'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
@stop

@section('body')
<script type="text/javascript">
  var detail = (incidence , user) => {
    bootbox.alert({
      title : "{{trans('messages.messages')}}",
    message: () => {
      return (
        '<strong>From</strong>: '+(user.name).toUpperCase() + ' '+(user.last_name).toUpperCase()+" [<strong>"+user.email+"</strong>] <br><br>"+
        '<strong>Subject</strong>: '+incidence.subject+"<br><br>"+
        '<strong>Message</strong>: '+incidence.description+"<br><br>"
      );
    }
});
  }
</script>
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble_office">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.subject')}}</th>
            <th>{{trans('messages.user')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($incidences as $incidence)
            <tr item="{{$incidence}}">
              <td>{{ucwords($incidence->id)}}</td>
              <td><a class="infoRd" href="javascript:detail({{$incidence}} , {{$user[$incidence->user]}})">{{ucwords($incidence->subject)}}</a></td>
              <td>{{($user[$incidence->user]->email)}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
