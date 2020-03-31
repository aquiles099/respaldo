<?php $lang = App::getLocale(); ?>
@include('sections.translate')

<form role="form" action="{{asset($path)}}" onsubmit="createLoad()" method="post">
  @if(isset($transport))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!--Transport Name -->
    <div class="form-group row @include('errors.field-class', ['field' => 'spanish'])">
      <label class="col-lg-3 control-label">{{trans('transport.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('transport.name')}}" name="spanish" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($transport) ? ($lang == 'es') ? ucwords($transport->spanish) : ucwords($transport->english) : clear(Input::get('spanish'))}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'spanish'])
      </div>
    </div>
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" id="divButton">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($transport)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
