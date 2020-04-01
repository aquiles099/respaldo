@set('js', ['js/includes/ConfigurationCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('configuration.adjustment'))
@section('title', trans('configuration.adjustment'))
@extends('pages.page')
@section('body')
@section('title-actions')
@stop
@include('pages.admin.configuration.messages')
@include('sections.messages')
<?php
    use App\Models\Admin\Configuration;

    $configuration = Configuration::find(1);
    $lang = isset($configuration->language) ? $configuration->language : 'en';
 ?>

  <div class="panel panel-default">
    <div class="panel-body">
      <form onsubmit="submitForm()" class="" action="{{asset('admin/configuration')}}" method="post" enctype="multipart/form-data">
        @if(isset($configuration))
          <input type="hidden" name="_method" value="patch">
        @endif
        <fieldset>
          <ul class="nav nav-tabs nav-justified">
            <li id="ics_inactive_tab0" class="active"><a data-toggle="tab" href="#ics_tab_home">{{trans('configuration.general')}} <span><i class="fa fa-cog" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab5"><a data-toggle="tab" href="#ics_tab_menu5">{{trans('configuration.load_users')}} <span><i class="fa fa-newspaper-o" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab1"><a data-toggle = "tab" href="#ics_tab_menu1">{{trans('configuration.reports')}} <span><i class="fa fa-file-text" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab2"><a data-toggle = "tab" href="#ics_tab_menu2">{{trans('configuration.label')}} <span><i class="fa fa-ticket" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab3"><a data-toggle = "tab" href="#ics_tab_menu3">{{trans('configuration.mail')}} <span><i class="fa fa-envelope" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab4"><a data-toggle = "tab" href="#ics_tab_menu4">{{trans('configuration.status_selection')}} <span><i class="fa fa-check-circle" aria-hidden="true"></i></span></a></li>
          </ul>
          </ul>
          <div class="tab-content">
            <div id="ics_tab_home"  class="tab-pane fade in active">
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-cog" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <!--logo-->
                  {{csrf_field()}}
                  <div class="form-group row @include('errors.field-class', ['field' => 'logo'])">
                     <label class="col-lg-3 control-label" for="logo" id="label">{{trans('configuration.logo')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.infoLogo')}}"></i></label>
                     <div class="col-md-2">
                        <img src="{{isset($configuration) && $configuration->logo_ics != null ? $configuration->logo_ics : asset('/uploads/logo/005.png')}}" class = "img-responsive img-rounded" data-toggle="tooltip" data-placement="top" title="{{trans('configuration.info')}}" style="height: 40px;">
                     </div>
                     <div class="col-lg-7">
                       <input type="file" class="file file-loading" name="logo" id="logo" accept="image/.jpg, image/.png" value="{{Input::get('logo') }}" >
                       <input type="hidden" name="h_logo" id="h_logo" value="{{isset($configuration)? $configuration->logo_ics : Input::get('logo') }}">
                        @include('sections.errors', ['errors' =>  $errors, 'name' => 'logo'])
                     </div>
                   </div>
                   <!--Nombre de la Empresa-->
                   <div class="form-group row @include('errors.field-class', ['field' => 'name_company'])" style="padding-top: 8px;">
                     <label class="col-lg-3 control-label" for="name_company" id="label">{{trans('configuration.name_company')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.name_company')}}"></i></label>
                     <div class="col-lg-9">
                       <input class="form-control" type="text" id="name_company" name="name_company" placeholder="{{trans('configuration.name_company')}}" value="{{isset($configuration) ? $configuration->name_company : Input::get('name_company')}}">
                       @include('sections.errors', ['errors' =>  $errors, 'name' => 'name_company'])
                     </div>
                  </div>
                  <!--Identificador de la Empresa-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'dni_company'])">
                    <label class="col-lg-3 control-label" for="dni_company" id="label">{{trans('configuration.dni_company')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.dni_company')}}"></i></label>
                    <div class="col-lg-9">
                      <input class="form-control" type="text" id="dni_company" name="dni_company" placeholder="{{trans('configuration.dni_company')}}" value="{{isset($configuration) ? $configuration->dni_company : Input::get('dni_company')}}">
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'dni_company'])
                    </div>
                 </div>
                 <!--Pais de la Empresa-->
                 <div class="form-group row @include('errors.field-class', ['field' => 'country_company'])">
                   <label class="col-lg-3 control-label">{{trans('configuration.country_company')}}</label>
                   <div class="col-lg-9">
                     <select class="form-control" name="country_company" placeholder="{{trans('messages.country_company')}}" required="true" value="{{Input::get('country_company')}}" id="country_company">
                       @if(isset($countrys))
                         @foreach($countrys as $value)
                           <option {{isset($configuration) && $configuration->country_company == $value ? 'selected' : '' }} value="{{$value}}">{{$value}}</option>
                         @endforeach
                       @endif
                     </select>
                     @include('sections.errors', ['errors' =>  $errors, 'name' => 'country_company'])
                   </div>
                 </div>
                 <!-- IDIOMA-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'hour_company'])">
                    <label class="col-lg-3 control-label">{{trans('configuration.language')}}</label>
                    <div class="col-lg-9">
                      <select style="width:100%;" class="form-control" name="language" placeholder="{{trans('configuration.language')}}" required="false" value="{{Input::get('hour_company')}}" id="hour_company">
                        <option {{isset($configuration->language)&&($configuration->language == 'en') ? 'selected' : ''}} value="0">{{trans('configuration.english')}}</option>
                        <option {{isset($configuration->language)&&($configuration->language == 'es') ? 'selected' : ''}} value="1">{{trans('configuration.spanish')}}</option>
                      </select>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'hour_company'])
                    </div>
                  </div>
                 <!-- ZONA HORARIA-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'hour_company'])">
                    <label class="col-lg-3 control-label">{{trans('Zona Horaria')}}</label>
                    <div class="col-lg-9">
                      <select style="width:100%;" class="form-control" name="hour_company" placeholder="{{trans('Zona Horaria')}}" required="false" value="{{Input::get('hour_company')}}" id="hour_company">
                        <option value="0">Seleccione su Zona Horaria</option>
                        @if(isset($countrys))
                          @foreach($timezones as $value)
                          <?php
                             if ($configuration->time_zone == $value) {
                                 $time =true;
                             }else {
                               $time =false;
                             }
                           ?>
                            <option {{($time == true) ? 'selected' : ''}} value="{{$value}}" >{{ucwords($value)}}</option>
                          @endforeach
                        @endif
                      </select>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'hour_company'])
                    </div>
                  </div>
                  <!--Region de la Empresa-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'region_company'])">
                    <label class="col-lg-3 control-label" for="region_company" id="label">{{trans('configuration.region_company')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.region_company')}}"></i></label>
                    <div class="col-lg-9">
                      <input class="form-control" type="text" id="region_company" name="region_company" placeholder="{{trans('configuration.region_company')}}" value="{{isset($configuration) ? $configuration->region_company : Input::get('region_company')}}">
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'region_company'])
                    </div>
                 </div>
                 <!--Ciudad de la Empresa-->
                 <div class="form-group row @include('errors.field-class', ['field' => 'city_company'])">
                   <label class="col-lg-3 control-label" for="city_company" id="label">{{trans('configuration.city_company')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.city_company')}}"></i></label>
                   <div class="col-lg-9">
                     <input class="form-control" type="text" id="city_company" name="city_company" placeholder="{{trans('configuration.city_company')}}" value="{{isset($configuration) ? $configuration->city_company : Input::get('city_company')}}">
                     @include('sections.errors', ['errors' =>  $errors, 'name' => 'city_company'])
                   </div>
                </div>
                <!--Email de la Empresa-->
                <div class="form-group row @include('errors.field-class', ['field' => 'email_company'])">
                  <label class="col-lg-3 control-label" for="email_company" id="label">{{trans('configuration.email_company')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.email_company')}}"></i></label>
                  <div class="col-lg-9">
                    <input class="form-control" type="email" id="email_company" name="email_company" placeholder="{{trans('configuration.email_company')}}" value="{{isset($configuration) ? $configuration->email_company : Input::get('email_company')}}">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'email_company'])
                  </div>
               </div>
               <!--Sitio web de la empresa-->
               <div class="form-group row @include('errors.field-class', ['field' => 'web_site_company'])">
                 <label class="col-lg-3 control-label" for="web_site_company" id="label">{{trans('configuration.website')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.websiteinfo')}}"></i></label>
                 <div class="col-lg-9">
                   <input class="form-control" type="text" id="web_site_company" name="web_site_company" placeholder="{{trans('configuration.website')}}" value="{{isset($configuration) ? $configuration->web_site_company : Input::get('web_site_company')}}">
                   @include('sections.errors', ['errors' =>  $errors, 'name' => 'web_site_company'])
                 </div>
              </div>
                <!--Terminos y Condiciones-->
                <div class="form-group row @include('errors.field-class', ['field' => 'terms'])" >
                  <label class="col-lg-3 control-label" for="terms_ics" id="label">{{trans('configuration.terms')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.infoTerms')}}"></i></label>
                  <div class="col-lg-9">
                    <textarea class="form-control" name="terms_ics" placeholder="{{trans('configuration.terms')}}">{{isset($configuration) ? $configuration->terms_ics : Input::get('terms_ics')}}</textarea>
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'terms'])
                  </div>
               </div>
                </div>
              </div>
            </div>
            <!--IMPORTAR ARCHIVO CON USUARIOS-->
            <div id="ics_tab_menu5" class="tab-pane fade" >
                <br><br>
                <!--PREFIJO-->
                <div class="col-md-1"></div>
                <label class="col-lg-2 control-label" for="terms_ics">{{trans('configuration.prefix')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('Codigo para los nuevos usuarios(Ej: USR, USER, U)')}}"></i></label>
                <div class="col-lg-9">
                  <input id="prefix" name="prefix" class="form-control" type="text" name="" placeholder="{{trans('configuration.prefix_placeholder')}}" value="{{isset($configuration->prefix)&&($configuration->prefix != '') ? $configuration->prefix : ''}}">
                  @include('sections.errors', ['errors' =>  $errors, 'name' => 'prefix'])
                </div>

                <!--Numero de iniscio de conteo-->
                <div class="col-md-1"><br></div>
                <label class="col-lg-2 control-label" for="terms_ics" >{{trans('configuration.num_ini')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('Este numero sera la referencia para empezar a codificar los nuevos usuarios')}}"></i></label>
                <div class="col-lg-9">
                  <input id="num_ini" name="num_ini" class="form-control" type="text" name="" placeholder="{{trans('configuration.num_ini_placeholder')}}" value="{{isset($configuration->num_ini)&&($configuration->num_ini != '') ? $configuration->num_ini : ''}}">
                  @include('sections.errors', ['errors' =>  $errors, 'name' => 'prefix'])
                </div>

                <div class="col-md-1"></div>
                    <label class="col-lg-2"for="">{{trans('configuration.upload_file')}}</label>
                    <input class="col-lg-9 form-control" style="width:40%;margin-left: 15px;" id="import_file" name="import_file" type="file">
                  </label>
                  @if($lang == 'es')
                    <div style="margin-left: 90px;margin-top:20px;  " class="col-md-12">
                      <label for="">Especificaciones del archivo</label>
                      <p style="font-size: 12px;">- Asegurese de que su archivo cumpla con el siguiente <a href="{{asset('/uploads/formato_users.xlsx')}}">formato.</a></p>
                      <p style="font-size: 12px;">- El correo electronico de cada usuario es obligatorio, si este campo esta vacio, el usuario sera ignorado, es decir, no se registrará en la base de datos.</p>
                    </div>
                  @else
                    <div style="margin-left: 90px;margin-top:20px;  " class="col-md-12">
                      <label for="">File Specifications</label>
                      <p style="font-size: 12px;">- Be sure your file meets the requirements of this <a href="{{asset('/uploads/formato_users.xlsx')}}">format.</a></p>
                      <p style="font-size: 12px;">- The e-mail field is fully required, if this isn't filled, the user won't be saved.</p>
                    </div>
                  @endif
            </div>
            <div id="ics_tab_menu1" class="tab-pane fade" >
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-file-text" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <!--Cabecera de reportes-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'headerReceipt'])">
                    <label class="col-lg-3 control-label" for="header_receipt" id="label">{{trans('configuration.headerReceipt')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.infoHeaderReceipt')}}"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="header_receipt" placeholder="{{trans('configuration.headerReceipt')}}">{{isset($configuration) ? $configuration->header_receipt : Input::get('header_receipt')}}</textarea>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'headerReceipt'])
                    </div>
                  </div>
                  <!--Pie de reportes-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'footerReceipt'])">
                    <label class="col-lg-3 control-label" for="footer_receipt" id="label">{{trans('configuration.footerReceipt')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.infoFooterReceipt')}}"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="footer_receipt" placeholder="{{trans('configuration.footerReceipt')}}">{{isset($configuration) ? $configuration->footer_receipt : Input::get('footer_receipt')}}</textarea>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'footerReceipt'])
                    </div>
                 </div>
                </div>
              </div>
            </div>
            <div id="ics_tab_menu2" class="tab-pane fade">
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-ticket" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <!--Header del formato de etiqueta -->
                  <div class="form-group row @include('errors.field-class', ['field' => 'headerLabel'])">
                    <label class="col-lg-3 control-label" for="header_label" id="label">{{trans('configuration.headerLabel')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.infoHeaderLabel')}}"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="header_label" placeholder="{{trans('configuration.headerLabel')}}" >{{isset($configuration) ? $configuration->header_label : Input::get('headerLabel')}}</textarea>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'headerLabel'])
                    </div>
                  </div>
                  <!--Footer del formato de etiqueta -->
                  <div class="form-group row @include('errors.field-class', ['field' => 'footerLabel'])">
                    <label class="col-lg-3 control-label" for="footer_label" id="label">{{trans('configuration.footerLabel')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.infoFooterLabel')}}"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="footer_label" placeholder="{{trans('configuration.footerLabel')}}">{{isset($configuration) ? $configuration->footer_label : Input::get('footerLabel')}}</textarea>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'footerLabel'])
                    </div>
                  </div>
                  <!--Datos de usuario-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'footerLabel'])">
                    <label class="col-lg-3 control-label" for="option_selected_label" id="label">{{trans('configuration.userData')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.userDataInfo')}}"></i></label>
                    <div class="col-lg-9">
                      <select class="form-control" name="option_selected_label" placeholder="{{trans('configuration.footerLabel')}}">
                        @foreach($optionUserData as $key => $value)
                          <option {{isset($configuration) && $configuration->option_selected_label == $value['id'] ? 'selected' : ''}} value="{{$value['id']}}">{{$value['text']}}</option>
                        @endforeach
                      </select>
                    </div>
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'footerLabel'])
                  </div>
                </div>
              </div>
            </div>
            <div id="ics_tab_menu3" class="tab-pane fade">
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <!--Header del correo que se enviara al usuario-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'header_mail'])">
                    <label class="col-lg-3 control-label" for="header_mail" id="label">{{trans('configuration.header_mail')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.infoheadermail')}}"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="header_mail" placeholder="{{trans('configuration.header_mail')}}" >{{isset($configuration) ? $configuration->header_mail : Input::get('header_mail')}}</textarea>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'header_mail'])
                    </div>
                  </div>
                  <!--Footer del correo que se enviara al usuario-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'footer_mail'])">
                    <label class="col-lg-3 control-label" for="footer_mail" id="label">{{trans('configuration.footer_mail')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('configuration.infofootermail')}}"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="footer_mail" placeholder="{{trans('configuration.footer_mail')}}" >{{isset($configuration) ? $configuration->footer_mail : Input::get('footer_mail')}}</textarea>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'headerLabel'])
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="ics_tab_menu4" class="tab-pane fade" >
              <div class="panel-body">
                <div class="panel panel-default" >
                     <div class="panel-heading text-muted">
                      <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                      <span class="pull-right">
                        <span class="text-muted">
                          <a role="button" onclick="addpackage()" class="btn btn-primary btn-xs">{{trans('configuration.addStatus')}} <i class="fa fa-plus" aria-hidden="true"></i> </a>
                        </span>
                      </span>
                     </div>
                  <div class="row" style="padding: 25px 30px 0 30px">
                      <ul class="nav nav-tabs" id="listpack">
                        <li class="paq active" id="lipaquete1" ><a data-toggle="tab" href="#paquete1"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> STATUS 1</a></li>
                      </ul>
                      <div class="tab-content" id="contentpack">
                        <div id="paquete1" class="tab-pane fade in active" style="padding:20px">
                           <div class="row" id="divTracking" style="">
                             <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'description'])"  id="divlarge" >
                                <label class="col-lg-2 control-label" id="typeLabel" >{{trans('messages.name')}}</label>
                                <div class="col-lg-10">
                                  <input type="text" class="form-control" placeholder="{{trans('messages.name')}}" id="name1" name="name1" value="" @include('form.readonly')>
                                      @include('errors.field', ['field' => 'description'])
                                </div>
                              </div>
                              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'description'])"  id="divlarge" >
                                <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.description')}}</label>
                                <div class="col-lg-10">
                                  <input type="text" class="form-control" placeholder="{{trans('package.description')}}" id="description1" name="description1"value="" @include('form.readonly')>
                                      @include('errors.field', ['field' => 'description'])
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2"></div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <input type ="hidden" name="countpack" id="countpack" value="1">
            </div>
          </div>
          <!-- Change this to a button or input when using this as a form -->
           @if(!isset($readonly) || !$readonly)
             <div class="col-md-12 buttons" id="divButton">
               <span id="divload"class="text-muted"></span>
               <button type="submit" class="btn btn-primary pull-right">
                 <i class="fa fa-floppy-o" aria-hidden="true"></i>
                 {{trans(isset($user)?'messages.update' : 'messages.save')}}
               </button>
             </div>
           @endif
        </fieldset>
      </form>
    </div>
  </div>
@stop
