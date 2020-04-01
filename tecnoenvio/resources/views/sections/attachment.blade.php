<div class="panel panel-default">
  <div class="panel-body">
    <fieldset role="form" class="form">
      <div class="row">
        <div class="col-md-12">
          <form class="dropzone dz-clickable" accept-charset="UTF-8" method="post" action="{{asset('/account/user/loadfile')}}" enctype="multipart/form-data" files="true" id="my-dropzone">
              <input type="hidden" name="attachment" value="" id="attachment">
              <div class="dz-default dz-message" style="margin-top: 10%"><h5><strong>{{trans('messages.attachFile')}} <i class="fa fa-paperclip" aria-hidden="true" data-toggle="tooltip" title="{{trans('messages.click')}}"></i></strong></h5></div>
          </form>
        </div>
      </div>
    </fieldset>
  </div>
  <div class="panel-footer">
    <div class="text-muted" style="text-align:right">
      <div class="pull-left" style="margin-top: 7px">
        <span>
          <i aria-hidden="true" class="fa fa-user"></i>
          @if(isset($user))
            {{strtoupper($user->name)}} {{strtoupper($user->last_name)}}
            <strong>({{$user->code}})</strong>
          @endif
        </span>
      </div>
      <button type="button" class="btn btn-primary btn-sm" id="submit">{{trans('messages.save')}}</button>
    </div>
  </div>
</div>
