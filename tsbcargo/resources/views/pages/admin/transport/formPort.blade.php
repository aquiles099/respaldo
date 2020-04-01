<div class="panel panel-default">
    <div class="panel-body">
    <form role="form"  method="post" id="formSerial">
      @if(isset($port))
        <input type="hidden" name="_method" value="patch">
      @endif
      <fieldset class="form">
        <!--Port Name -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
        <label class="col-lg-3 control-label">{{trans('transport.namePort') }}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('transport.namePort')}}" name="name" id="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($port) ? $port->name : '' }}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!--Service Price -->
        <div class="form-group row @include('errors.field-class', ['field' => 'price'])">
          <label class="col-lg-3 control-label">{{trans('transport.description')}}</label>
          <div class="col-lg-9">
              <textarea class="form-control" placeholder="{{trans('transport.description')}}" name="description" id="description" type="text" autofocus maxlength="100" min="3" required="true" @include('form.readonly')>{{isset($port) ? $port->description : '' }}</textarea>
            @include('errors.field', ['field' => 'description'])
          </div>
        </div>
      </fieldset>
    </form>
    </div>
    <div class="panel-footer" id="pft2">
    @if(!isset($readonly) || !$readonly)
      <a @if (isset($port)) href="javascript:icsEditPort({{$port->id}}, {{$port->transport}})" @else href="javascript:icsAddPort({{$transport->id}})" @endif>
        <span class="badge" data-toggle="tooltip" title="{{trans('transport.save')}}">
          <span class="glyphicon glyphicon-ok"></span>
        </span>
      </a>
    @else
       <a href="javascript:icsViewPort({{$port->id}},false)">
        <span class="badge" data-toggle="tooltip" title="{{trans('transport.editPort')}}">
          <span class="glyphicon glyphicon-pencil"></span>
        </span>
      </a>
    @endif
    </div>
</div>
