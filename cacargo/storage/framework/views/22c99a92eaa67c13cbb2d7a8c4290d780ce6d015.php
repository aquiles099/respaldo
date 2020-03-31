<?php $js =  ['js/includes/ConfigurationCtrl.js']; ?>
<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('pageTitle', trans('configuration.adjustment')); ?>
<?php $__env->startSection('title', trans('configuration.adjustment')); ?>

<?php $__env->startSection('body'); ?>
<?php $__env->startSection('title-actions'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.configuration.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('sections.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <form onsubmit="submitForm()" class="" action="<?php echo e(asset('admin/configuration')); ?>" method="post" enctype="multipart/form-data">
        <?php if(isset($configuration)): ?>
          <input type="hidden" name="_method" value="patch">
        <?php endif; ?>
        <fieldset>
          <ul class="nav nav-tabs nav-justified">
            <li id="ics_inactive_tab0" class="active"><a data-toggle="tab" href="#ics_tab_home"><?php echo e(trans('configuration.general')); ?> <span><i class="fa fa-cog" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab3"><a data-toggle = "tab" href="#ics_tab_menu3"><?php echo e(trans('configuration.mail')); ?> <span><i class="fa fa-envelope" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab4"><a data-toggle = "tab" href="#ics_tab_menu4"><?php echo e(trans('configuration.status_selection')); ?> <span><i class="fa fa-check-circle" aria-hidden="true"></i></span></a></li>

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
                  <?php echo e(csrf_field()); ?>

                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'logo'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                     <label class="col-lg-3 control-label" for="logo" id="label"><?php echo e(trans('configuration.logo')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.infoLogo')); ?>"></i></label>
                     <div class="col-md-2">
                        <img src="<?php echo e(isset($configuration) && $configuration->logo_ics != null ? $configuration->logo_ics : asset('/uploads/logo/005.png')); ?>" class = "img-responsive img-rounded" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('configuration.info')); ?>" style="height: 40px;">
                     </div>
                     <div class="col-lg-7">
                       <input type="file" class="file file-loading" name="logo" id="logo" accept="image/.jpg, image/.png" value="<?php echo e(Input::get('logo')); ?>" >
                       <input type="hidden" name="h_logo" id="h_logo" value="<?php echo e(isset($configuration)? $configuration->logo_ics : Input::get('logo')); ?>">
                        <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'logo'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                     </div>
                   </div>
                   <!--Nombre de la Empresa-->
                   <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'name_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" style="padding-top: 8px;">
                     <label class="col-lg-3 control-label" for="name_company" id="label"><?php echo e(trans('configuration.name_company')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.name_company')); ?>"></i></label>
                     <div class="col-lg-9">
                       <input class="form-control" type="text" id="name_company" name="name_company" placeholder="<?php echo e(trans('configuration.name_company')); ?>" value="<?php echo e(isset($configuration) ? $configuration->name_company : Input::get('name_company')); ?>">
                       <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'name_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                     </div>
                  </div>
                  <!--Identificador de la Empresa-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'dni_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="dni_company" id="label"><?php echo e(trans('configuration.dni_company')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.dni_company')); ?>"></i></label>
                    <div class="col-lg-9">
                      <input class="form-control" type="text" id="dni_company" name="dni_company" placeholder="<?php echo e(trans('configuration.dni_company')); ?>" value="<?php echo e(isset($configuration) ? $configuration->dni_company : Input::get('dni_company')); ?>">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'dni_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                 </div>
                 <!--Pais de la Empresa-->
                 <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'country_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                   <label class="col-lg-3 control-label"><?php echo e(trans('configuration.country_company')); ?></label>
                   <div class="col-lg-9">
                     <select class="form-control" name="country_company" placeholder="<?php echo e(trans('messages.country_company')); ?>" required="true" value="<?php echo e(Input::get('country_company')); ?>" id="country_company">
                       <?php if(isset($countrys)): ?>
                         <?php foreach($countrys as $value): ?>
                           <option <?php echo e(isset($configuration) && $configuration->country_company == $value ? 'selected' : ''); ?> value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                         <?php endforeach; ?>
                       <?php endif; ?>
                     </select>
                     <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'country_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                   </div>
                 </div>
                 <!-- IDIOMA-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'hour_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label"><?php echo e(trans('configuration.language')); ?></label>
                    <div class="col-lg-9">
                      <select style="width:100%;" class="form-control" name="language" placeholder="<?php echo e(trans('configuration.language')); ?>" required="false" value="<?php echo e(Input::get('hour_company')); ?>" id="hour_company">
                        <option <?php echo e(isset($configuration->language)&&($configuration->language == 'en') ? 'selected' : ''); ?> value="0"><?php echo e(trans('configuration.english')); ?></option>
                        <option <?php echo e(isset($configuration->language)&&($configuration->language == 'es') ? 'selected' : ''); ?> value="1"><?php echo e(trans('configuration.spanish')); ?></option>
                      </select>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'hour_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                 <!-- ZONA HORARIA-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'hour_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label"><?php echo e(trans('configuration.timezone')); ?></label>
                    <div class="col-lg-9">
                      <select style="width:100%;" class="form-control" name="hour_company" placeholder="<?php echo e(trans('Zona Horaria')); ?>" required="false" value="<?php echo e(Input::get('hour_company')); ?>" id="hour_company">
                        <option value="0"><?php echo e(trans('configuration.chooseTimezone')); ?></option>
                        <?php if(isset($countrys)): ?>
                          <?php foreach($timezones as $value): ?>
                          <?php
                             if ($configuration->time_zone == $value) {
                                 $time =true;
                             }else {
                               $time =false;
                             }
                           ?>
                            <option <?php echo e(($time == true) ? 'selected' : ''); ?> value="<?php echo e($value); ?>" ><?php echo e(ucwords($value)); ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'hour_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--Region de la Empresa-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'region_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="region_company" id="label"><?php echo e(trans('configuration.region_company')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.region_company')); ?>"></i></label>
                    <div class="col-lg-9">
                      <input class="form-control" type="text" id="region_company" name="region_company" placeholder="<?php echo e(trans('configuration.region_company')); ?>" value="<?php echo e(isset($configuration) ? $configuration->region_company : Input::get('region_company')); ?>">
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'region_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                 </div>
                 <!--Ciudad de la Empresa-->
                 <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'city_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                   <label class="col-lg-3 control-label" for="city_company" id="label"><?php echo e(trans('configuration.city_company')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.city_company')); ?>"></i></label>
                   <div class="col-lg-9">
                     <input class="form-control" type="text" id="city_company" name="city_company" placeholder="<?php echo e(trans('configuration.city_company')); ?>" value="<?php echo e(isset($configuration) ? $configuration->city_company : Input::get('city_company')); ?>">
                     <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'city_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                   </div>
                </div>
                <!--Email de la Empresa-->
                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'email_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                  <label class="col-lg-3 control-label" for="email_company" id="label"><?php echo e(trans('configuration.email_company')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.email_company')); ?>"></i></label>
                  <div class="col-lg-9">
                    <input class="form-control" type="email" id="email_company" name="email_company" placeholder="<?php echo e(trans('configuration.email_company')); ?>" value="<?php echo e(isset($configuration) ? $configuration->email_company : Input::get('email_company')); ?>">
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'email_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
               </div>
               <!--Sitio web de la empresa-->
               <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'web_site_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                 <label class="col-lg-3 control-label" for="web_site_company" id="label"><?php echo e(trans('configuration.website')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.websiteinfo')); ?>"></i></label>
                 <div class="col-lg-9">
                   <input class="form-control" type="text" id="web_site_company" name="web_site_company" placeholder="<?php echo e(trans('configuration.website')); ?>" value="<?php echo e(isset($configuration) ? $configuration->web_site_company : Input::get('web_site_company')); ?>">
                   <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'web_site_company'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                 </div>
              </div>
                <!--Terminos y Condiciones-->
                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'terms'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" >
                  <label class="col-lg-3 control-label" for="terms_ics" id="label"><?php echo e(trans('configuration.terms')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.infoTerms')); ?>"></i></label>
                  <div class="col-lg-9">
                    <textarea class="form-control" name="terms_ics" placeholder="<?php echo e(trans('configuration.terms')); ?>"><?php echo e(isset($configuration) ? $configuration->terms_ics : Input::get('terms_ics')); ?></textarea>
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'terms'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
               </div>
                </div>
              </div>
            </div>
            <div id="ics_tab_menu1" class="tab-pane fade" >
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-file-text" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <!--Cabecera de reportes-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'headerReceipt'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="header_receipt" id="label"><?php echo e(trans('configuration.headerReceipt')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.infoHeaderReceipt')); ?>"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="header_receipt" placeholder="<?php echo e(trans('configuration.headerReceipt')); ?>"><?php echo e(isset($configuration) ? $configuration->header_receipt : Input::get('header_receipt')); ?></textarea>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'headerReceipt'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--Pie de reportes-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'footerReceipt'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="footer_receipt" id="label"><?php echo e(trans('configuration.footerReceipt')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.infoFooterReceipt')); ?>"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="footer_receipt" placeholder="<?php echo e(trans('configuration.footerReceipt')); ?>"><?php echo e(isset($configuration) ? $configuration->footer_receipt : Input::get('footer_receipt')); ?></textarea>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'footerReceipt'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'headerLabel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="header_label" id="label"><?php echo e(trans('configuration.headerLabel')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.infoHeaderLabel')); ?>"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="header_label" placeholder="<?php echo e(trans('configuration.headerLabel')); ?>" ><?php echo e(isset($configuration) ? $configuration->header_label : Input::get('headerLabel')); ?></textarea>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'headerLabel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--Footer del formato de etiqueta -->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'footerLabel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="footer_label" id="label"><?php echo e(trans('configuration.footerLabel')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.infoFooterLabel')); ?>"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="footer_label" placeholder="<?php echo e(trans('configuration.footerLabel')); ?>"><?php echo e(isset($configuration) ? $configuration->footer_label : Input::get('footerLabel')); ?></textarea>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'footerLabel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--Datos de usuario-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'footerLabel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="option_selected_label" id="label"><?php echo e(trans('configuration.userData')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.userDataInfo')); ?>"></i></label>
                    <div class="col-lg-9">
                      <select class="form-control" name="option_selected_label" placeholder="<?php echo e(trans('configuration.footerLabel')); ?>">
                        <?php foreach($optionUserData as $key => $value): ?>
                          <option <?php echo e(isset($configuration) && $configuration->option_selected_label == $value['id'] ? 'selected' : ''); ?> value="<?php echo e($value['id']); ?>"><?php echo e($value['text']); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'footerLabel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'header_mail'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="header_mail" id="label"><?php echo e(trans('configuration.header_mail')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.infoheadermail')); ?>"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="header_mail" placeholder="<?php echo e(trans('configuration.header_mail')); ?>" ><?php echo e(isset($configuration) ? $configuration->header_mail : Input::get('header_mail')); ?></textarea>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'header_mail'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                  </div>
                  <!--Footer del correo que se enviara al usuario-->
                  <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'footer_mail'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
                    <label class="col-lg-3 control-label" for="footer_mail" id="label"><?php echo e(trans('configuration.footer_mail')); ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo e(trans('configuration.infofootermail')); ?>"></i></label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="footer_mail" placeholder="<?php echo e(trans('configuration.footer_mail')); ?>" ><?php echo e(isset($configuration) ? $configuration->footer_mail : Input::get('footer_mail')); ?></textarea>
                      <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'headerLabel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                          <a role="button" onclick="addpackage()" class="btn btn-primary btn-xs">Agregar Estado <i class="fa fa-plus" aria-hidden="true"></i> </a>
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
                              <div class=" dimensmedidas  <?php echo $__env->make('errors.field-class', ['field' => 'description'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>"  id="divlarge" >
                                <label class="col-lg-2 control-label" id="typeLabel" ><?php echo e(trans('messages.name')); ?></label>
                                <div class="col-lg-10">
                                  <input type="text" class="form-control" placeholder="<?php echo e(trans('messages.name')); ?>" id="name1" name="name1" value="" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                                      <?php echo $__env->make('errors.field', ['field' => 'description'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                              </div>
                              <div class=" dimensmedidas  <?php echo $__env->make('errors.field-class', ['field' => 'description'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>"  id="divlarge" >
                                <label class="col-lg-2 control-label" id="typeLabel" ><?php echo e(trans('package.description')); ?></label>
                                <div class="col-lg-10">
                                  <input type="text" class="form-control" placeholder="<?php echo e(trans('package.description')); ?>" id="description1" name="description1"value="" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                                      <?php echo $__env->make('errors.field', ['field' => 'description'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
           <?php if(!isset($readonly) || !$readonly): ?>
             <div class="col-md-12 buttons" id="divButton">
               <span id="divload"class="text-muted"></span>
               <button type="submit" class="btn btn-primary pull-right">
                 <i class="fa fa-floppy-o" aria-hidden="true"></i>
                 <?php echo e(trans(isset($user)?'messages.update' : 'messages.save')); ?>

               </button>
             </div>
           <?php endif; ?>
        </fieldset>
      </form>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>