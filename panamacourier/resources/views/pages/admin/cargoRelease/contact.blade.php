<fieldset item ="{{$cargo_release}}">
  <div class="row">
    <!--first square-->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b>{{trans('cargoRelease.contact_name')}}:</b></td>
              <td>{{isset($cargo_release) ? $cargo_release->contact_name : ''}}</td>
            </tr>
            <tr>
              <td><b>{{trans('cargoRelease.contact_phone')}}:</b></td>
              <td>{{isset($cargo_release) ? $cargo_release->contact_phone : ''}}</td>
            </tr>
            <tr>
              <td><b>{{trans('cargoRelease.contact_country')}}:</b></td>
              <td>{{isset($cargo_release) ? $cargo_release->contact_country : ''}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  <!--second square-->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <table class="table table-striped">
          <tr>
            <td><b>{{trans('cargoRelease.contact_region')}}:</b></td>
            <td>{{isset($cargo_release) ? $cargo_release->contact_region: ''}}</td>
          </tr>
          <tr>
            <td><b>{{trans('cargoRelease.contact_city')}}:</b></td>
            <td>{{isset($cargo_release) ? $cargo_release->contact_city : ''}}</td>
          </tr>
          <tr>
            <td><b>{{trans('cargoRelease.contact_postal_code')}}:</b></td>
            <td>{{isset($cargo_release) ? $cargo_release->contact_postal_code : ''}}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <label for="contact_address">{{trans('cargoRelease.contact_address')}}:</label>
      <textarea name="contact_address" class="form-control" readonly="true">{{isset($cargo_release) ? $cargo_release->contact_address : ''}}</textarea>
    </div>
  </div>
</fieldset>
