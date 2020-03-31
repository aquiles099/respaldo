<fieldset>
  <div class="row">
    <div class="col-md-12">
      <form class="dropzone dz-clickable" accept-charset="UTF-8" method="post" action="{{asset($path)}}" enctype="multipart/form-data" files="true" id="my-dropzone">
          <input type="hidden" name="attachments" value="" id="attachments">
          <div class="dz-default dz-message"><h5><strong>{{trans('attachment.attachFile')}} <i class="fa fa-paperclip" aria-hidden="true" data-toggle="tooltip" title="{{trans('attachment.click')}}"></i></strong></h5></div>
      </form>
    </div>
  </div>
</fieldset>
