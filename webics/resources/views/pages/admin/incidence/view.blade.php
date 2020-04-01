<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <p>
                <strong>Asunto:</strong> {{isset($incidence->subject) ? $incidence->subject : ''}}
              </p>
              <p>
                <strong>Descripcion:</strong> {{isset($incidence->description) ?  $incidence->description :'' }}
              </p>
              <p>
                <strong>Perfil:</strong> {{isset($incidence->profile) ?  $incidence->profile : ''}}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <img class="img-thumbnail" src="{{isset($incidence->img) ? $incidence->img : ''}}" alt="" />
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">{{trans('incidence.answer')}}</div>
            <div class="panel-body">
                {{isset($incidence->asnwer) ? $incidence->asnwer : ''}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
