<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reportes de Paquetes</title>
    <!-- Customize favicon-->
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('/uploads/logo/005.png')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>" media="screen" title="no title" charset="utf-8">
  </head>
  <?php echo $__env->make('sections.translate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <body class="pdfBody">
    <!--Se define la cabecera del pdf, contiene logo e informacion de la empresa-->
    <header class = "pdfHeader">
      <table>
        <tr>
          <td>
              <img src="<?php echo e(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg')); ?>" alt="logo" />
          </td>
          <td>
            <p>
                <?php echo e(isset($configuration) ? ($configuration->header_receipt == '') ? trans('configuration.noheader') : $configuration->header_receipt : trans('configuration.noheader')); ?>

          </td>
        </tr>
      </table>
      </div>
      <hr>
    </header>
    <div class="pdfInfo">
        <?php echo e(trans('package.packages')); ?>

    </div>
      <!--Datos informativos del paquete-->

    <!--Tabla con registros listados-->
    <br>
    <table class="pdfTable">
      <thead>
        <tr>
          <th ><?php echo e(trans('messages.id')); ?></th>
          <th ><?php echo e(trans('messages.package')); ?></th>
          <th ><?php echo e(trans('messages.user')); ?></th>
          <th ><?php echo e(trans('messages.event')); ?></th>
          <th ><?php echo e(trans('messages.service_order')); ?></th>
          <th ><?php echo e(trans('messages.dimensions')); ?></th>
          <th ><?php echo e(trans('messages.date')); ?></th>
          <th ><?php echo e(trans('messages.tracking')); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(isset($package)): ?>
          <?php foreach($package as $row): ?>
            <tr>
              <td><?php echo e($row->id); ?></td>
              <td><?php echo e($row->code); ?></td>
              <td><?php echo e(isset($row->getToUser->code) ? $row->getToUser->code : ''); ?> <?php echo e(isset($row->getToUser->name) ? $row->getToUser->name : ''); ?></td>
              <td><?php echo e(isset($row->getLastEvent->description) ? $row->getLastEvent->description : ''); ?></td>
              <td><?php echo e(isset($row->order_service) ? $row->order_service : ''); ?></td>
              <td><?php echo e($row->width); ?>x<?php echo e($row->height); ?>x<?php echo e($row->large); ?></td>
              <td><?php echo e($row->start_at); ?></td>
              <td><?php echo e($row->tracking); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
      <!--Se define el pie de pagina-->
    <div class="pdfFooter">
      <p>
          <?php echo e(isset($configuration) ? ($configuration->footer_receipt == '') ? trans('configuration.nofooter') : $configuration->footer_receipt : trans('configuration.nofooter')); ?>

      </p>
    </div>
  </body>
</html>
