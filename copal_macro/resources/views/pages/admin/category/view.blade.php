<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    @if(isset($category))
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    @endif
    <form role="form" action="" method="" id="formSerial">
      <fieldset class="form">
        <!--name -->
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
        @if(isset($taxes) )
        <div class="form-group ">
            <label class="col-lg-3 row control-label">{{trans('category.tax')}}</label>
            <div class="col-lg-9">
              <table class="table table-striped table-hover" style="margin-left: 4%; text-align:center" >
                <thead>
                  <th>{{trans('messages.name')}}</th>
                  <th>{{trans('messages.value')}}</th>
                  <th>{{trans('messages.active')}}</th>
                </thead>
                <tbody>
                  @foreach($taxes as $tax)
                    <tr item="{{$tax->toInnerJson()}}">
                      <td>{{$tax->name}}</td>
                      <td>{{$tax->value}}</td>
                      <td><input type="checkbox" name="tax{{$tax->id}}" value="{{$tax->id}}" @foreach($taxCategory as $taxCat) @if($tax->id == $taxCat->getTax->id) checked @endif @endforeach @if($readonly==true) disabled="disable" @endif></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
        @endif
      </fieldset>
    </form>
  </div>
</div>
