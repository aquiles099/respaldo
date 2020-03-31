<form role="form" action="{{asset($path)}}" method="post">
  @if(isset($category))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'label'])">
      <label class="col-lg-3 control-label">{{trans('category.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('category.name')}}" name="label" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($category) ? $category->label : Input::get('label')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'label'])
      </div>
    </div>
    <!--percentage -->
    <div class="form-group row @include('errors.field-class', ['field' => 'percentage'])">
      <label class="col-lg-3 control-label">{{trans('category.percentage')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('category.percentage')}}" name="percentage" type="float" autofocus min="1" required="true" value="{{isset($category) ? $category->percentage : Input::get('percentage')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'percentage'])
      </div>
    </div>
    <!--Tax-->
    @if(isset($taxes) && count($taxes) > 0)
    <div class="form-group ">
        <label class="col-lg-3 row control-label">{{trans('category.tax')}}</label>
        <div class="col-lg-9">
          <table class="table table-striped table-hover" style="margin-left: 4%; text-align:center" >
            <thead>
              <th>{{trans('messages.name')}}</th>
              <th>{{trans('messages.value')}}</th>
              <th>{{trans('messages.type')}}</th>
              <th>{{trans('messages.active')}}</th>
            </thead>
            <tbody>
              @foreach($taxes as $tax)
              <tr>
                <td>{{$tax->name}}</td>
                <td>{{$tax->value}}</td>
                <td>{{($tax->type == 0) ? 'Porcentaje (%)' : 'Fijo ($)' }}</td>
                <td><input type="checkbox" name="tax{{$tax->id}}" value="{{$tax->id}}" id="tax{{$tax->id}}"></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
    @endif
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($percentage)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
