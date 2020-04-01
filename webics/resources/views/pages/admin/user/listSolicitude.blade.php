@set('js', ['src/js/solicitude.js'])
@set('js', ['src/js/user.js'])
<form class="" action="{{asset("admin/users/{$user->id}")}}/solicitude" method="post">
  <fieldset class="form">
    <table class="table table-striped table-hover table-responsive" name="solicitudeTable" id="solicitudeTable">
      <thead>
        <tr>
          <th style="text-align: center"></th>
          <th style="text-align: center">{{trans('solicitude.code')}}</th>
          <th style="text-align: center">{{trans('solicitude.status')}}</th>
          <th style="text-align: center">{{trans('solicitude.subject')}}</th>
          <th style="text-align: center">{{trans('solicitude.client')}}</th>
          <th style="text-align: center">{{trans('solicitude.profile')}}</th>
          <th style="text-align: center">{{trans('solicitude.created_at')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $key => $value)
        <tr item="">
          <td>
            <input id="{{$value->id}}" type="checkbox" name="{{$value->id}}" value="{{$value->id}}" @foreach ($userdata as $key => $item) @if($item->id==$value->admin) checked @endif @endforeach>
          </td>
          <td>
            <p class="">{{$value->code}}</p>
          </td>
          <!--Estado-->
          <td>
            @if($value->status == App\Helpers\HStatus::GENERATED)<span class="label label-default">{{$value->getStatus['name']}}</span>@endif
            @if($value->status == App\Helpers\HStatus::FORMSENDED)<span class="label label-warning">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
            @if($value->status == App\Helpers\HStatus::FORMRECEIVED)<span class="label label-primary">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
            @if($value->status == App\Helpers\HStatus::ONCOURSE)<span class="label label-primary">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
            @if($value->status == App\Helpers\HStatus::PROCESED)<span class="label label-primary">{{isset($value->getStatus['name']) ? $value->getStatus['name'] : '' }}</span>@endif
          </td>
          <td>{{$value->subject}}</td>
          <td>{{isset($value->getClient->email) ? $value->getClient->email : trans('messages.unknown')}}</td>
          <td>
            @if ($value->profile == '1')
              {{trans('messages.micro')}}
            @elseif ($value->profile == '2')
              {{trans('messages.macro')}}
              @else
              {{trans('messages.unknown')}}
            @endif
          </td>
          <td>{{$value->created_at}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="col-xs-2">
      <!-- Action -->
      <button id="sendButton" type="submit" class="btn btn-primary pull-right" name="button">{{trans('messages.send')}}</button>
    </div>
  </fieldset>
</form>
