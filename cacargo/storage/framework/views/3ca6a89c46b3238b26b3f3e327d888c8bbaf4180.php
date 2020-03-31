<?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <fieldset class="form">
    <!--Primer cuadro, se muestra tracking, origen y destino-->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b><?php echo e(trans('messages.code')); ?>:</b></td>
              <td><?php echo e(isset($package) ? $package->code : Input::get('code')); ?></td>
            </tr>
            <tr>
              <td><b><?php echo e(trans('package.from')); ?>:</b></td>
              <td><?php echo e(isset($package) ? (isset($package->to_client) ? strtoupper($companyclient->name) : strtoupper($package->getCourier['name'])) : ''); ?></td>
            </tr>
            <tr>
              <td><b><?php echo e(trans('package.to')); ?>:</b></td>
              <?php if(isset($package) && $package->to_client != null): ?>
                <td><?php echo e($package->getToClient->getCompany->name); ?> <?php echo e($package->getToClient->code); ?> <?php echo e($package->getToClient->name); ?> <?php echo e($package->getToClient->email); ?> </td>
              <?php else: ?>
                <td><?php if($package->to_user != null): ?> <?php echo e($package->getToUser->code); ?> <?php echo e($package->getToUser->name); ?> <?php echo e($package->getToUser->email); ?> <?php endif; ?></td>
              <?php endif; ?>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!--Segundo cuadro, se muestra tipo, categoria y estado -->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b><?php echo e(trans('package.type')); ?>:</b></td>
              <td><?php echo e(isset($package) ? $package->getType['spanish']: ''); ?></td>
            </tr>
            <tr>
              <td><b><?php echo e(trans('package.status')); ?>:</b></td>
              <td><?php echo e(isset($package) ? ucfirst($package->getLastEvent->name) : ''); ?></td>
            </tr>
            <tr>
              <td><b><?php echo e(trans('messages.order_service')); ?>:</b></td>
              <td><?php echo e(isset($package) ? $package->order_service : ''); ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!-- listar estados del paquete y cambiar los mismos -->
    <?php if($package->last_event <= 5): ?>
    <div class="col-md-12" id="packevnt">
      <div class="panel panel-default">
         <div class="panel-body">
            <div class="col-md-6 " style="padding-right: 0px;padding-left: 0px;">
              <label class="col-lg-3 control-label" id="labelDirection" ><?php echo e(trans('package.observation')); ?>:</label>
              <div class="col-lg-9">
                 <input class="form-control" style="height:28px" placeholder="<?php echo e(trans('package.observation')); ?>" id="observation" name="observation" type="text" value="" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                          <?php echo $__env->make('errors.field', ['field' => 'obervation'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
            </div>
            <div class="col-md-4" style="padding-right: 0px;padding-left: 0px;">
              <label class="col-lg-3 control-label" id="labelDirection" ><?php echo e(trans('package.status')); ?>:</label>
              <div class="col-lg-9">
                <select  class="form-control " id="event" name="event" required="true" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>>
                     <?php foreach($event as $row): ?>
                        <?php if(($row->id > $package->last_event)&&($row->active == 1)): ?>
                          <option value=<?php echo e($row->id); ?>> <?php echo e(ucfirst($row->name)); ?></option>
                       <?php endif; ?>
                     <?php endforeach; ?>
                  </select>
              </div>
            </div>
            <div class="col-md-2" id="button">
              <button  type="button" class="btn btn-primary" onclick="changestatuspackage(<?php echo e($package->id); ?>)">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo e(trans('messages.save')); ?>

              </button>
            </div>
          </div>
      </div>
    </div>
    <div class="progress" id="cl"  style="display:none; margin-left:100px; width:80%;">
      <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:50%">
        <span class="sr-only"></span>
      </div>
    </div>
    <?php endif; ?>
    <!--Tabla de eventos del paquete actual -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="pull-center"><?php echo e(trans('messages.events')); ?>

            <?php foreach($invoice as $file): ?>
              <span class="pull-right" id="packinvo">
                <a href="<?php echo e($file->path); ?>" download="<?php echo e(trans('messages.invoice')); ?>">
                  <small><?php echo e(trans('messages.invoice')); ?> <i class="fa fa-download" aria-hidden="true"></i></small>
               </a>
             </span>
           <?php endforeach; ?>
        </div>
        </div>
        <div class="panel-body">
          <table class="table table-striped" id="dtble2">
            <thead>
              <tr style="text-align:center">
                <th><?php echo e(trans('messages.package')); ?></th>
                <th><?php echo e(trans('messages.user')); ?></th>
                <th><?php echo e(trans('messages.event')); ?></th>
                <th><?php echo e(trans('messages.observation')); ?></th>
              </tr>
            </thead>
            <tbody id="table">
              <?php if(isset($packageLog)): ?>
                <?php foreach($packageLog as $row): ?>
                  <tr style="text-align: center">
                    <td><?php echo e($package->code); ?></td>
                    <td><?php echo e(ucwords($row->getUser['name'])); ?></td>
                    <td><?php echo e(ucfirst($row->getEvent['description'])); ?></td>
                    <td><?php echo e(ucfirst($row->observation)); ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </fieldset>
