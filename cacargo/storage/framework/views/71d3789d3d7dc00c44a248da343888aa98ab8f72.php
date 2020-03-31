<?php
    use App\Models\Admin\Configuration;

    $configuration = Configuration::find(1);
    $lang = $configuration->language;
    App::setLocale($lang);
 ?>
<form  id="formulario" role="form" method="post" novalidate method="post">
  <fieldset>
    <?php if(isset($package)): ?>
      <input type="hidden" name="_method" value="patch">
    <?php endif; ?>
    <div class="breadcrumb">
      <i aria-hidden="true" class="fa fa-paper-plane-o"></i>
      <?php echo e(trans('package.courier')); ?>

    </div>
    <div class="id_100 form-group row <?php echo $__env->make('errors.field-class', ['field' => 'courierSelect'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>">
      <div class="col-md-12">
        <select class="form-control" id="courierSelect" name="courierSelect" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
          <?php foreach($couriers as $courier): ?>
            <option <?php echo e((isset($package->from_courier) ? $package->from_courier : Input::get('from_courier')) == $courier->id ? 'selected' : ''); ?> value="<?php echo e($courier->id); ?>"><?php echo e(strtoupper($courier->name)); ?></option>
          <?php endforeach; ?>
        </select>
        <?php echo $__env->make('errors.field', ['field' => 'courierSelect'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
    <!--tabs-->
    <ul class="nav nav-tabs nav-justified">
      <li  class="active"><a data-toggle = "tab" href="#ics_tab_menu0"><?php echo e(trans('package.packageinfo')); ?> <span><i class="fa fa-cube" aria-hidden="true"></i></span></a></li>
      <li><a data-toggle="tab" href="#ics_tab_menu1"><?php echo e(trans('package.destinyinfo')); ?> <span><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
      <li><a data-toggle="tab" href="#ics_tab_menu2"><?php echo e(trans('package.paymentinfo')); ?> <span><i class="fa fa-usd" aria-hidden="true"></i></span></a></li>
    </ul>
    <!--content-->
    <div class="tab-content">
      <!--tab 0-->
      <div id="ics_tab_menu0" class="tab-pane fade in active">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-cube" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <!--tracking
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'tracking'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divTracking"  >
              <div class="col-lg-3">
                <label for="tracking"><?php echo e(trans('package.tracking')); ?></label>
              </div>
              <div class="col-lg-9">
                <input class="form-control form_dimension" placeholder="<?php echo e(trans('package.tracking')); ?>" id="tracking" name="tracking" type="text" maxlength="25" min="10" required="true" value="<?php echo e(isset($package) ? $package->tracking : clear(Input::get('tracking'))); ?>" <?php echo $__env->make('form.readonly',['forceReadonly' => isset($package)], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                <?php echo $__env->make('errors.field', ['field' => 'tracking'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>-->
            <!--service order-->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'service_order'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id=""  >
              <div class="col-lg-3">
                <label for="service_order"><?php echo e(trans('package.tracking')); ?></label>
                <span id="ics_service_order" class="pull-right"></span>
              </div>
              <div class="col-lg-9">
                <div class="input-group" style="width:94%!important" >
                  <input class="form-control form_dimension" placeholder="<?php echo e(trans('package.tracking')); ?>" id="service_order" name="service_order" type="text" maxlength="25" min="10" required="true" value="<?php echo e(isset($package) ? $package->order_service : clear(Input::get('service_order'))); ?>">
                  <span class = "input-group-addon">
                    <a href="javascript:icsSearchPrealert()" class="text-muted" data-toggle="tooltip" title="<?php echo e(trans('package.queryprealert')); ?>">
                        <i aria-hidden="true" class="fa fa-search"></i>
                    </a>
                  </span>
                </div>
                <?php echo $__env->make('errors.field', ['field' => 'service_order'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>
            <!--large-->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'large'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>"  id="divlarge">
              <div class="col-lg-3">
                <label for="large"><?php echo e(trans('package.large')); ?></label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="<?php echo e(trans('package.large')); ?>" id="large" name="large" onkeyup="pesovol()" type="float" style="display: inline;" maxlength="10" min="1" required="true" value="<?php echo e(isset($package) ? $package->large : clear(Input::get('large'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                 <span>in</span>
                  <?php echo $__env->make('errors.field', ['field' => 'large'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>
            <!--width-->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'width'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" onkeyup="pesovol()" id="divwidth">
              <div class="col-lg-3">
                <label for="width"><?php echo e(trans('package.width')); ?></label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="<?php echo e(trans('package.width')); ?>" id="width" name="width" type="float" maxlength="10" min="1" style="display: inline;" required="true" value="<?php echo e(isset($package) ? $package->width : clear(Input::get('width'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                 <span>in</span>
                  <?php echo $__env->make('errors.field', ['field' => 'width'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>
            <!--height-->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'height'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" onkeyup="pesovol()" id="divheight">
              <div class="col-lg-3">
                <label for="height"><?php echo e(trans('package.height')); ?></label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="<?php echo e(trans('package.height')); ?>" id="height" onkeyup="pesovol()" name="height"  type="float" maxlength="10" min="1" required="true" value="<?php echo e(isset($package) ? $package->height : clear(Input::get('height'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                 <span>in</span>
                  <?php echo $__env->make('errors.field', ['field' => 'height'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>
            <!--weight-->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'weight'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" onkeyup="pesovol()" id="divweight">
              <div class="col-lg-3">
                <label for="weight"><?php echo e(trans('package.weight')); ?></label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="<?php echo e(trans('package.weight')); ?>" id="weight" onkeyup="pesovol()" name="weight" type="float" maxlength="10" min="1" required="true" value="<?php echo e(isset($package) ? $package->weight : clear(Input::get('weight'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                 <span>lb</span>
                  <?php echo $__env->make('errors.field', ['field' => 'weight'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>
            <!--value-->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'value'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" onkeyup="pesovol()" id="divvalue">
              <div class="col-lg-3">
                <label for="value"><?php echo e(trans('package.value')); ?></label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="<?php echo e(trans('package.value')); ?>" id="value" name="value" type="float" maxlength="10" min="1" required="true" value="<?php echo e(isset($package) ? $package->value : clear(Input::get('value'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                <span>$</span>
                <?php echo $__env->make('errors.field', ['field' => 'value'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>

            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'volumetricweight'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divtype" >
                <label class="col-lg-3 control-label" id="typeLabel" style="line-height: 18px!important;" ><?php echo e(trans('package.volumem')); ?></label>
                <div class="col-lg-9">
                       <input class="form-control form_dimension"  placeholder="<?php echo e(trans('package.volumem')); ?>" id="volumetricweightm" name="volumetricweightm" type="float" maxlength="10" min="1" readonly required="true" value="<?php echo e(isset($package) ? $package->volumetricweightm : clear(Input::get('volumetricweightm'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                        <span>ft<sup>3</sup></span>
                          <?php echo $__env->make('errors.field', ['field' => 'volumetricweightm'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>

            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'volumetricweight'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divtype" >
                <label class="col-lg-3 control-label" id="typeLabel" style="line-height: 18px!important;" ><?php echo e(trans('package.volumea')); ?></label>
                <div class="col-lg-9">
                       <input class="form-control form_dimension"  placeholder="<?php echo e(trans('package.volumea')); ?>" id="volumetricweighta" name="volumetricweighta" type="float" maxlength="10" min="1" readonly required="true" value="<?php echo e(isset($package) ? $package->volumetricweighta : clear(Input::get('volumetricweighta'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                       <span>Vlb</span>
                          <?php echo $__env->make('errors.field', ['field' => 'volumetricweighta'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>


          </div>
        </div>
      </div>
      <!--tab 1-->
      <div id="ics_tab_menu1" class="tab-pane fade">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-user" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <!--user select-->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'finalDestinationUser'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="destination" style="display:block;"}}>
              <label class="col-lg-3 control-label"><?php echo e(trans('package.destination')); ?></label>
              <div class="col-lg-9">
              <select class="form-control" id="finalDestinationUser" name="finalDestinationUser"  <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> >
              <option value=""><?php echo e(trans('package.chooseClient')); ?></option>
                <?php foreach($users as $user): ?>
                  <?php $option = $user->toOption();?>
                  <option <?php echo e((isset($package) ? $package->to_user : Input::get('to_user')) == $option['id'] ? 'selected' : ''); ?> item="<?php echo e($user->toInnerJson()); ?>" value="<?php echo e($option['id']); ?>"><?php echo $option['text']; ?></option>
                <?php endforeach; ?>
              </select>
             </div>
            </div>
            <!--user name-->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="clientName" >
             <label class="col-lg-3 control-label" id="labelName" ><?php echo e(trans('package.clientName')); ?></label>
             <div class="col-lg-9">
               <input class="form-control" placeholder="<?php echo e(trans('package.clientName')); ?>" id="name" name="name" type="text" maxlength="25" min="5" required="true" value="<?php echo e(isset($package->getToUser) ? $package->getToUser->name : clear(Input::get('name'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                 <?php echo $__env->make('errors.field', ['field' => 'name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
             </div>
           </div>
            <!--user phone-->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'phone'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="clientPhone" >
              <label class="col-lg-3 control-label" id="labelPhone" ><?php echo e(trans('package.clientPhone')); ?></label>
              <div class="col-lg-9">
                <input class="form-control" placeholder="<?php echo e(trans('package.clientPhone')); ?>" id="phone" name="phone" type="text" maxlength="25" min="5" required="true" value="<?php echo e(isset($package->getToUser) ? $package->getToUser->local_phone : clear(Input::get('phone'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                  <?php echo $__env->make('errors.field', ['field' => 'phone'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>
            <!--user email -->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="clientEmail" >
              <label class="col-lg-3 control-label" id="labelEmail" ><?php echo e(trans('package.clientEmail')); ?></label>
              <div class="col-lg-9">
                <input class="form-control" placeholder="<?php echo e(trans('package.clientEmail')); ?>" id="email" name="email" type="text" maxlength="50" min="5" required="true" value="<?php echo e(isset($package->getToUser) ? $package->getToUser->email : clear(Input::get('email'))); ?>"<?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                  <?php echo $__env->make('errors.field', ['field' => 'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>
            <!--user dni -->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'identifier'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="clientIdentifier" >
              <label class="col-lg-3 control-label" id="labelIdentifier" ><?php echo e(trans('package.clientIdentifier')); ?></label>
              <div class="col-lg-9">
                <input class="form-control" placeholder="<?php echo e(trans('package.clientIdentifier')); ?>" id="identifier" name="identifier" type="text" maxlength="25" min="5" required="true" value="<?php echo e(isset($package->getToUser) ? $package->getToUser->dni : clear(Input::get('identifier'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                  <?php echo $__env->make('errors.field', ['field' => 'identifier'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>

            <!--user Address -->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'direction'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divDirection" >
              <label class="col-lg-3 control-label" id="labelDirection" ><?php echo e(trans('package.address')); ?></label>
              <div class="col-lg-9">
                <textarea class="form-control" placeholder="<?php echo e(trans('package.address')); ?>" id="direction" name="direction" type="text" maxlength="250" min="5" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> value = "<?php echo e(isset($package->getToUser) ? $package->getToUser['address'] : clear(Input::get('address'))); ?>"><?php echo e(isset($package->getToUser) ? $package->getToUser->country.', '.$package->getToUser->region.', '.$package->getToUser->city.', '.$package->getToUser->address: clear(Input::get('address'))); ?></textarea>
                  <?php echo $__env->make('errors.field', ['field' => 'observation'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>
            <!--user observation -->
            <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'observation'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divObservation" >
              <label class="col-lg-3 control-label" id="labelObservation" ><?php echo e(trans('package.observation')); ?></label>
              <div class="col-lg-9">
                <textarea class="form-control" placeholder="<?php echo e(trans('package.observation')); ?>" id="observation" name="observation" type="text" maxlength="250" min="5" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>><?php echo e(isset($package) ? $receipt->observation : clear(Input::get('observation'))); ?></textarea>
                  <?php echo $__env->make('errors.field', ['field' => 'observation'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!--tab 2-->
      <div id="ics_tab_menu2" class="tab-pane fade">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-usd" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <div class="row">
              <!--type-->
              <div class="col-md-6">
                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'type'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="idtype" >
                  <label class="col-lg-3 control-label" id="typeLabel" ><?php echo e(trans('package.service')); ?></label>
                  <div class="col-lg-9">
                    <select class="form-control" id="type" name="type" required="true" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                    <option value="" cost="0"><?php echo e(trans('package.nottype')); ?></option>
                        <?php foreach($transports as $transport): ?>
                          <?php $option = $transport->toOption();?>
                          <option <?php echo e((isset($package) ? $package->type : Input::get('type')) == $option['id'] ? 'selected' : ''); ?> item="<?php echo e($transport->toInnerJson()); ?>" value="<?php echo e($option['id']); ?>" cost="<?php echo e($option['price']); ?>"><?php echo e(ucwords($option['text'])); ?> </option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo $__env->make('errors.field', ['field' => 'type|'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>


                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'type'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="idtype" >
                  <label class="col-lg-3 control-label" id="typeLabel" ><?php echo e(trans('package.type')); ?></label>
                  <div class="col-lg-9">
                    <select class="form-control" id="typeservice" name="typeservice" required="true" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                    <option value=""><?php echo e(trans('package.notservice')); ?></option>
                    <?php if($tytransport!=''): ?>
                        <?php foreach($tytransport as $transport): ?>
                          <?php $option = $transport->toOption();?>
                          <option <?php echo e((isset($package) ? $package->dettype : Input::get('type')) == $option['id'] ? 'selected' : ''); ?> item="<?php echo e($transport); ?>" cost="<?php echo e($option['price']); ?>" value="<?php echo e($option['id']); ?>"><?php echo e($option['text']); ?> <?php echo e($option['price']); ?>($)</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </select>
                    <?php echo $__env->make('errors.field', ['field' => 'type|'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>

              <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'taxval'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" style="display:block;">
                <label class="col-lg-3 control-label" id="servicelabel" ><?php echo e(trans('package.taxx')); ?></label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="<?php echo e(trans('package.taxx')); ?>" id="taxval" onkeyup="calctax()" name="taxval" type="text" maxlength="5"  value="<?php echo e(isset($tax->value) ? $tax->value : ''); ?>">
                  <?php echo $__env->make('errors.field', ['field' => 'taxval'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                </div>
              </div>

               <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'insurance'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" style="display:block;">
                <label class="col-lg-3 control-label" id="servicelabel" ><?php echo e(trans('package.insurance')); ?></label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="<?php echo e(trans('package.insurance')); ?>" id="insurance" onkeyup="calcinsurance()" name="insurance" type="text" maxlength="5"   value="<?php echo e(isset($insurance) ? $insurance->value_oring : clear(Input::get('insurance'))); ?>">
                  <?php echo $__env->make('errors.field', ['field' => 'tracking'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('errors.field', ['field' => 'insurance'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
              </div>

              <div class="hidden form-group row <?php echo $__env->make('errors.field-class', ['field' => 'addcharge'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" >
                  <label class="col-lg-3 control-label" id="officeLabel" style="line-height: 15px;" ><?php echo e(trans('package.addcharge')); ?></label>
                  <div class="col-lg-9">
                    <select class="form-control" id="addcharge" name="addcharge"  <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                     <option value=""><?php echo e(trans('package.chorgeaddcharge')); ?></option>
                     <?php foreach($addcharge as $addcharges): ?>
                      <option <?php echo e(isset($idaddcharge) && $idaddcharge->id_complemento==$addcharges->id ? 'selected':''); ?> item="<?php echo e($addcharges); ?>" cost="<?php echo e($addcharges->value); ?>"  value="<?php echo e($addcharges->id); ?>" ><?php echo e($addcharges->name); ?>-<?php echo e($addcharges->value); ?>$</option>
                     <?php endforeach; ?>
                    </select>
                    <?php echo $__env->make('errors.field', ['field' => 'office'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>


              <div class="hidden form-group row <?php echo $__env->make('errors.field-class', ['field' => 'office'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="officeDiv" >
                  <label class="col-lg-3 control-label" id="officeLabel" ><?php echo e(trans('package.office')); ?></label>
                  <div class="col-lg-9">
                    <select class="form-control" id="office" name="office"  <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                     <option value=""><?php echo e(trans('package.chooseOffice')); ?></option>
                     <?php foreach($office as $offi): ?>
                        <?php $option = $offi->toOption();?>
                        <option <?php echo e((isset($package) ? $package->office : Input::get('office')) == $option['id'] ?  'selected' : ''); ?> item="<?php echo e($offi->toInnerJson()); ?>"  value="<?php echo e($option['id']); ?>" ><?php echo e($option['text']); ?></option>
                     <?php endforeach; ?>
                    </select>
                    <?php echo $__env->make('errors.field', ['field' => 'office'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!-- -->
                <div class="hidden form-group row <?php echo $__env->make('errors.field-class', ['field' => 'category'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="categoryDiv" >
                  <label class="col-lg-3 control-label" id="categoryLabel" ><?php echo e(trans('package.category')); ?></label>
                  <div class="col-lg-9">
                    <select class="form-control" id="category" name="category" required="true" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                        <?php foreach($category as $cat): ?>
                          <?php $option = $cat->toOption();?>
                          <option <?php echo e((isset($package) ? $package->category : Input::get('category')) == $option['id'] ? 'selected' : ''); ?> item="<?php echo e($cat->toInnerJson()); ?>"  porcent="<?php echo e($option['percent']); ?>" value="<?php echo e($option['id']); ?>" cost="<?php echo e($option['percent']); ?>"><?php echo e($option['text']); ?> </option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <!-- -->
                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'invoice'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="invoice" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" ><?php echo e(trans('package.invoice')); ?></label>
                  <div class="col-lg-9">
                    <select class="form-control" id="invoice" name="invoice" required="true" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                      <?php /*se comenta el codigo php para que se inicalice el select como 'sin factura'*/ ?>
                        <option <?php /*(isset($package) ? $package->invoice : 0) == 0 ? 'selected' : ''*/ ?> value=0><?php echo e(trans('package.withOutInvoice')); ?></option>
                        <option <?php /*(isset($package) ? $package->invoice : 1) == 1 ? 'selected' : ''*/ ?> value=1><?php echo e(trans('package.withInvoice')); ?></option>
                    </select>
                    </div>
                </div>
                <!-- -->
                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'id_package'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="uploadinvoice" style="padding-left: 30%;display:none">
                    <input type="file" name="file" id="file" accept=".pdf, image/*" autofocus value="<?php echo e(Input::get('file')); ?>" >
                    <?php echo $__env->make('sections.errors', ['errors' =>  $errors, 'name' => 'id_package'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <!-- -->
                <div class="hidden form-group row <?php echo $__env->make('errors.field-class', ['field' => 'consolidate'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="consolidate" style="display:block;">
                  <label class="col-lg-3 control-label" id="invoiceLabel" ><?php echo e(trans('package.consolidated')); ?></label>
                  <div class="col-lg-9">
                   <select class="form-control" id="consolidated" name="consolidated" required="true" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                   <option value=""><?php echo e(trans('package.notconsolidated')); ?></option>
                        <?php foreach($consolidated as $consol): ?>
                          <?php $option = $consol->toOption();?>
                          <option <?php echo e((isset($package->consolidated) ? $package->consolidated : Input::get('type')) == $option['id'] ? 'selected' : ''); ?> item="<?php echo e($transport->toInnerJson()); ?>" value="<?php echo e($option['id']); ?>"><?php echo e($option['text']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-muted"><?php echo e(trans('messages.optional')); ?></span>
                  </div>
                </div>
                <!---->
                <div class="hidden form-group row <?php echo $__env->make('errors.field-class', ['field' => 'consolidate'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="consolidate" style="display:block;">
                  <label class="col-lg-3 control-label" id="invoiceLabel" ><?php echo e(trans('package.promotion')); ?></label>
                  <div class="col-lg-9">
                   <select class="form-control" id="promotion" name="promotion" required="true" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                   <option value=""><?php echo e(trans('package.notpromotion')); ?></option>
                        <?php foreach($promotions as $promo): ?>
                          <?php $option = $promo->toOption();?>
                          <option <?php echo e((isset($promotion->id_complemento) ? $promotion->id_complemento : Input::get('type')) == $option['id'] ? 'selected' : ''); ?>  item="<?php echo e($promo); ?>" value="<?php echo e($option['id']); ?>" reduction="<?php echo e($option['reduction']); ?>"><?php echo e($option['text']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-muted"><?php echo e(trans('messages.optional')); ?></span>
                  </div>
                </div>
              </div>
              <!-- isset($package) && $package->type == 1 ? $package->volumetricweightm.' ft3' : isset($package) && $package->type == 2 ? $package->volumetricweighta.' Vlb' :''-->
              <div class="col-md-6">
                <!-- -->
                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'tax'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="taxdiv" >
                    <label class="col-lg-3 control-label" id="invoiceLabel" ><?php echo e(trans('package.volume')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control"  placeholder="<?php echo e(trans('package.volume')); ?>" id="volre" name="volre" readonly  type="float" maxlength="10" min="1" required="true" value="<?php if(isset($package) && $package->type == 1): ?> <?php echo e($package->volumetricweightm); ?>.ft3 <?php elseif(isset($package) && $package->type == 2): ?> <?php echo e($package->volumetricweighta); ?>Vlb <?php endif; ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                      <?php echo $__env->make('errors.field', ['field' => 'value'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                </div>

                <!--Costo total por el servicio -->
                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'costservice'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divsubtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 15px;" ><?php echo e(trans('package.costservice')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control"  placeholder="<?php echo e(trans('package.costservice')); ?>" id="costservice" name="costservice" type="float" maxlength="10" min="1" required="true" readonly value="<?php echo e(isset($idtytransport) ? $idtytransport->price : clear(Input::get('value'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                    <?php echo $__env->make('errors.field', ['field' => 'subtotal'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>


                <!--Valor de Cargos Adicionales -->

                <div class="hidden form-group row <?php echo $__env->make('errors.field-class', ['field' => 'costadd'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divsubtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 15px;"><?php echo e(trans('package.costadd')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control"  placeholder="<?php echo e(trans('package.costadd')); ?>" id="costadd" name="costadd" type="float" maxlength="10" min="1" required="true" readonly value="<?php echo e(isset($idaddcharge) ? $idaddcharge->value_package : clear(Input::get('value'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                    <?php echo $__env->make('errors.field', ['field' => 'subtotal'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>

                <!--Valor del Seguro -->

                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'costinsu'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divsubtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 15px;"><?php echo e(trans('package.costinsurence')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control"  placeholder="<?php echo e(trans('package.costinsurence')); ?>" id="costinsu" name="costinsu" type="float" maxlength="10" min="1" required="true" readonly  value="<?php echo e(isset($insurance) ? $insurance->value_package : clear(Input::get('insurance'))); ?>"<?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                    <?php echo $__env->make('errors.field', ['field' => 'subtotal'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>



                <!--subtotal -->
                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'subtotal'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divsubtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" ><?php echo e(trans('package.subtotal')); ?></label>
                  <div class="col-lg-9">
                    <input class="form-control"  placeholder="<?php echo e(trans('package.subtotal')); ?>" id="subtotal" name="subtotal" type="float" maxlength="10" min="1" required="true" readonly value="<?php echo e(isset($receipt) ? $receipt->subtotal : clear(Input::get('value'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                    <?php echo $__env->make('errors.field', ['field' => 'subtotal'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>

                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'tax'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="taxdiv" >

                    <label class="col-lg-3 control-label" id="invoiceLabel" ><?php echo e(trans('package.tax')); ?></label>
                    <div class="col-lg-9">
                      <input class="form-control"  placeholder="<?php echo e(trans('package.tax')); ?>" id="taxre" name="taxre" readonly  type="float" maxlength="10" min="1" required="true"  value="<?php echo e(isset($tax->valuep) ? $tax->valuep : ''); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                    <?php echo $__env->make('errors.field', ['field' => 'value'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                </div>

                <!--promotion-->
                <div class="hidden form-group row <?php echo $__env->make('errors.field-class', ['field' => 'promotionval'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divalpromotion"  >
                  <label class="col-lg-3 control-label" id="invoiceLabel" ><?php echo e(trans('package.promotionselect')); ?></label>
                  <div class="col-lg-9">
                     <input class="form-control"  placeholder="<?php echo e(trans('package.notpromotionna')); ?>" id="promotionval" name="promotionval" type="float" maxlength="10" min="1" required="true" readonly value="<?php echo e(isset($promotion->value_package) ? $promotion->value_package : clear(Input::get('value'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                          <?php echo $__env->make('errors.field', ['field' => 'promotionval'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <!--total-->
                <div class="form-group row <?php echo $__env->make('errors.field-class', ['field' => 'total'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>" id="divtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" ><?php echo e(trans('package.total')); ?></label>
                  <div class="col-lg-9">
                     <input class="form-control"  placeholder="<?php echo e(trans('package.total')); ?>" id="total" name="total" type="float" maxlength="10" min="1" required="true" readonly value="<?php echo e(isset($receipt) ? $receipt->total : clear(Input::get('total'))); ?>" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                          <?php echo $__env->make('errors.field', ['field' => 'total'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div>
                </div>
                <input type ="hidden" name="start_at" id="start_at" value="<?php echo e($start_at); ?>">
              </div>
              </div>
              <?php if(!isset($readonly) || !$readonly): ?>
              <div class="col-lg-12 buttons"  id="divButton">
                <span id="ics_user_notify" class="text-muted"></span>
                <button onclick="icsNotifyUserSubmit()"  id="loginButton" type="submit" class="btn btn-primary pull-right">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                  <?php echo e(trans(isset($package)?'messages.update' : 'messages.save')); ?>

                </button>
              </div>
            <?php endif; ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </fieldset>
</form>
