<div class="container">
  <div class="row">
    <div class="span12">
      <div class="cform" id="contact-form">
        <form action="{{asset("$path")}}" method="post" onsubmit="icsGeneralLoad('sendButton')" enctype="multipart/form-data">
          @if(isset($notice))
            {{method_field('patch')}}
          @endif
          <!--Titulo-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('notice.title')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'title'])">
                <input type="text" id="title"  name="title" class="form-control" value="{{isset($notice) ? $notice->title : Input::get('title')}}"  placeholder="{{trans('notice.title')}}" required="true" />
                @include('errors.field', ['field' => 'title'])
              </div>
            </div>
          </div>
          <!--Extracto-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('notice.extract')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'extract'])">
                <input type="text" id="extract"  name="extract" class="form-control" value="{{isset($notice) ? $notice->extract : Input::get('extract')}}"  placeholder="{{trans('notice.extract')}}" required="true" />
                @include('errors.field', ['field' => 'extract'])
              </div>
            </div>
          </div>
          <!--Imagen-->
          <div class="row" style="margin-bottom: 45px">
            <div class="col-md-1 ">
              <label for="">{{trans('notice.img')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'img']) {{isset($notice) ? 'col-md-4' : ''}}"  style="margin-bottom: 45px">
                <input type="file" name="img" id="img" accept="image/*" >
                @include('errors.field', ['field' => 'img'])
              </div>
              @if(isset($notice))
              <div class="col-md-4">
                <img src="{{$notice->img}}" style="width: 100px; height: 70px" alt="" />
              </div>
              @endif
            </div>
          </div>
          <!--Status-->
          <div class="row" style="margin-bottom: 45px">
            <div class="col-md-1 ">
              <label for="">{{trans('notice.status')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field your-email form-group @include('errors.field-class', ['field' => 'published'])">
                <select class="form-control" name="published">
                  <option value="-1">{{trans('messages.selectoption')}}</option>
                  @foreach($statuses as $key => $value)
                    <option {{isset($notice) && $notice->published == $value['id'] ? 'selected' : ''}} value="{{$value['id']}}">{{$value['text']}}</option>
                  @endforeach
                </select>
                @include('errors.field', ['field' => 'published'])
              </div>
            </div>
          </div>
          <!--Cuerpo-->
          <div class="row" style="margin-bottom: 0px">
            <div class="col-md-1 ">
              <label for="">{{trans('messages.description')}}</label>
            </div>
            <div class="col-md-8 ">
              <div class="field message form-group @include('errors.field-class', ['field' => 'description'])">
                <textarea class="ckeditor" name="description" id="description" rows="10" cols="80" required="true">{{isset($notice) ? $notice->description : Input::get('description')}}</textarea>
                @include('errors.field', ['field' => 'description'])
              </div>
              <div style="text-align: right">
                <button id="sendButton" type="submit" class="btn btn-primary" name="button">{{trans('messages.send')}}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
