<form role="form" action="" method="post">
  @if(isset($category))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    
    <!-- -->
    <div class="row" style="margin-bottom: 18px;">
      <div class="col-md-6">
        <div class="form-group floating-box" style="margin: 0px;border: 1px solid rgba(158, 158, 158, 0.54);">
          <label class="col-lg-3 control-label">{{trans('consolidated.code')}}</label>
          <div class="col-lg-9">
            <label class="col-lg-10 control-label" style="font-weight: 500;">{{isset($consolidated) ? $consolidated->code : Input::get('code')}}</label>
          </div>

          <label class="col-lg-3 control-label">{{trans('consolidated.description')}}</label>
          <div class="col-lg-9">
            <label class="col-lg-10 control-label" style="font-weight: 500;">{{isset($consolidated) ? $consolidated->description : Input::get('description')}}</label>
          </div>

          <label class="col-lg-3 control-label">{{trans('consolidated.observation')}}</label>
          <div class="col-lg-9">
            <label class="col-lg-10 control-label" style="font-weight: 500;">{{isset($consolidated) ? $consolidated->observation : Input::get('observation')}}</label>
          </div>
        </div>
      </div>


    <div class="col-md-6">
        <div class="form-group floating-box" style="margin: 0px;border: 1px solid rgba(158, 158, 158, 0.54);">
          <label class="col-lg-3 control-label">{{trans('consolidated.status')}}</label>
          <div class="col-lg-9">
            <label class="col-lg-10 control-label" style="font-weight: 500;">{{isset($consolidated) ? (($consolidated->status == 1) ? trans('consolidated.open') :  trans('consolidated.close')) : 'status'}}</label>
          </div>

          <label class="col-lg-3 control-label">{{trans('messages.date')}}</label>
          <div class="col-lg-9">
            <label class="col-lg-10 control-label" style="font-weight: 500;">{{isset($consolidated) ? $consolidated->created_at : Input::get('created_at')}}</label>
          </div>
        </div>
      </div>
  </div>

  <div class="row"> 
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div>

              <label style="display: inline-block;" class="control-label" id="invoiceLabel" >{{trans('messages.changeStatus')}}</label>

              <select style="display: inline-block; width:250px" class="form-control" id="event" name="event" required="true" @include('form.readonly')>
                @foreach ($event as $row)
                  <option value={{$row->id}}> {{$row->description}}</option>
                @endforeach
              </select>

              <button type="button" style="display: inline-block;"  class="btn btn-primary" onclick="changestatusconsolidated({{$consolidated->id}})">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                  {{trans('messages.save')}}
              </button>
            </div>
         </div>
        </div>
      </div>
    </div>
    


    <h3 class="page-header" id="clientTitle" style="display:block;margin: 0px 0 0px;text-decoration: underline;">
      <div class="pull-center">{{trans('package.list')}}</div>
    </h3>
    <!-- -->
    <table class="table table-striped" id="tableHeader" style="display:block;">
      <thead>
        <tr>
          <th style="width:5%">{{trans('messages.id')}}</th>
          <th style="width:12%">{{trans('messages.package')}}</th>
          <th style="width:20%">{{trans('messages.date')}}</th>
          <th style="width:20%">{{trans('messages.event')}}</th>
          <th style="width:100%">{{trans('messages.observation')}}</th>
        </tr>
      </thead>
      <tbody id="table">
        @if(isset($packageConsolidated))
        @foreach ($packageConsolidated as $row)
          <tr>
            <td>{{$row->id}}</td>
            <td>{{$row->getPackage['tracking']}}</td>
            <td>{{$row->created_at}}</td>
            <td>{{ $consolidated->getLastEvent['description']}}</td>
            <td>{{$row->observation}}</td>
          </tr>
        @endforeach
        @endif
        </tr>
      </tfoot>
    </table>
    </div>
  </fieldset>
</form>

