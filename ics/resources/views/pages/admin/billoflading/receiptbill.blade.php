<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Bill Of Lading {{isset($pickup) ? $pickup->code : clear(Input::get('bl'))}}</title>
    <link rel="stylesheet" href="{{asset('styles.css')}}" media="screen" title="no title" charset="utf-8">
  </head>
  <body class="pdfBody">
    <!--Se define la cabecera del pdf, contiene logo e informacion de la empresa-->
    <header class = "pdfHeader">
      <h2>Bill Of Lading {{isset($pickup) ? $pickup->code : clear(Input::get('bl'))}} </h2>
    </header>





    <div class="pdfInfo">
      <table width:"100%" border='0' align='center' cellspacing='4' cellpadding='0'>
        <thead>
          <tr>
            <td> hola2</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="width:300px!important;height:50px">
            <p >{{isset($billoflading) ? nl2br($billoflading->exporter) : clear(Input::get('obervation'))}}</p>
            </td>
           
          </tr>    
        </tbody>
      
        

      </table>

      <div style="width:50%">
        <div class="@include('errors.field-class', ['field' => 'exporter'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.exporter')}}</label>
 +
              <textarea type="text" class="form-control" placeholder="{{trans('billoflading.exporter')}}" id="exporter" name="exporter" type="text" rows="5" min="1" required="true" value="{{isset($billoflading) ? $billoflading->exporter : clear(Input::get('obervation'))}}" @include('form.readonly')> {{isset($billoflading) ? $billoflading->exporter : clear(Input::get('obervation'))}}</textarea>
              @include('errors.field', ['field' => 'exporter'])
            </div>

            <div class="@include('errors.field-class', ['field' => 'consigne'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.consigne')}}</label>
              <textarea type="text" class="form-control" placeholder="{{trans('billoflading.consigne')}}" id="consigne" name="consigne" type="text" rows="5" min="1" required="true" value="{{isset($billoflading) ? $billoflading->consignedto : clear(Input::get('consignedto'))}}" @include('form.readonly')>{{isset($billoflading) ? $billoflading->consignedto : clear(Input::get('consignedto'))}}</textarea>
              @include('errors.field', ['field' => 'consigne'])
            </div>

            <div class="@include('errors.field-class', ['field' => 'notify'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.notify')}}</label>
              <textarea type="text" class="form-control" placeholder="{{trans('billoflading.notify')}}" id="notify" name="notify" type="text" rows="4" min="1" required="true" value="{{isset($billoflading) ? $billoflading->notify : clear(Input::get('notify'))}}" @include('form.readonly')> {{isset($billoflading) ? $billoflading->notify : clear(Input::get('notify'))}}</textarea>
              @include('errors.field', ['field' => 'notify'])
            </div>
            <div class="row">
              <div class="col-md-6">
          <div class="@include('errors.field-class', ['field' => 'precarri'])"  id="divlarge" >
                    <label class=" control-label" id="typeLabel" >{{trans('billoflading.precarri')}}</label>
                    <input type="text" class="form-control" placeholder="{{trans('billoflading.precarri')}}" id="precarri" name="precarri" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->precarri : clear(Input::get('precarri'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'precarri'])
                </div>     

                <div class="@include('errors.field-class', ['field' => 'exporting'])"  id="divlarge" >
                    <label class=" control-label" id="typeLabel" >{{trans('billoflading.exporting')}}</label>
                    <input type="text" class="form-control" placeholder="{{trans('billoflading.exporting')}}" id="exporting" name="exporting" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->exporting : clear(Input::get('exporting'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'exporting'])
                </div>  

                <div class="@include('errors.field-class', ['field' => 'foreing'])"  id="divlarge" >
                    <label class=" control-label" id="typeLabel" >{{trans('billoflading.foreing')}}</label>
                    <input type="text" class="form-control" placeholder="{{trans('billoflading.foreing')}}" id="foreing" name="foreing" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->foreing : clear(Input::get('foreing'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'foreing'])
                </div> 


              </div>

              <div class="col-md-6">
                <div class="@include('errors.field-class', ['field' => 'place'])"  id="divlarge" >
                    <label class=" control-label" id="typeLabel" >{{trans('billoflading.place')}}</label>
                    <input type="text" class="form-control" placeholder="{{trans('billoflading.place')}}" id="place" name="place" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->place : clear(Input::get('place'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'place'])
                </div> 

                <div class="@include('errors.field-class', ['field' => 'port'])"  id="divlarge" >
                    <label class=" control-label" id="typeLabel" >{{trans('billoflading.port')}}</label>
                    <input type="text" class="form-control" placeholder="{{trans('billoflading.port')}}" id="port" name="port" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->port : clear(Input::get('port'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'port'])
                </div> 

                <div class="@include('errors.field-class', ['field' => 'placedeli'])"  id="divlarge" >
                    <label class=" control-label" id="typeLabel" >{{trans('billoflading.placedeli')}}</label>
                    <input type="text" class="form-control" placeholder="{{trans('billoflading.placedeli')}}" id="placedeli" name="placedeli" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->placedeli : clear(Input::get('placedeli'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'placedeli'])
                </div> 

              </div>
            </div>
      </div>   

      <div style="width:50%">
        
      </div>   
    </div>

  

    

  



      <!--Se define el pie de pagina-->
    <div class="pdfFooter">
      
      </p>
    </div>
  </body>
</html>
