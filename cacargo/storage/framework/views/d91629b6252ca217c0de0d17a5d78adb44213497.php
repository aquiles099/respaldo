<!DOCTYPE html>
<html lang="es">
<head>
    <base href="<?php echo e(asset('/')); ?>" target="_self">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $__env->yieldContent('pageTitle', trans('Murano')); ?></title>

    <!-- Customize favicon-->
    <link rel="shortcut icon" type="image/png" href="<?php echo e(isset($configuration_header) ? ($configuration_header->logo_ics == '') ? asset('/uploads/logo/005.png') : asset('/uploads/logo/005.png') : asset('/uploads/logo/005.png')); ?>"/>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo e(asset('bower_components/bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <!-- jquery-editable-select -->
    <link href="<?php echo e(asset('bower_components/jquery-editable-select/dist/jquery-editable-select.min.css')); ?>" rel="stylesheet">
   <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">-->

    <!-- select2 -->
    <link href="<?php echo e(asset('js/select2/css/select2.css')); ?>" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?php echo e(asset('bower_components/metisMenu/dist/metisMenu.min.css')); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo e(asset('dist/css/sb-admin-2.css')); ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo e(asset('bower_components/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css">

    <link href="<?php echo e(asset('styles.css')); ?>" rel="stylesheet" type="text/css">

    <link href="<?php echo e(asset('libs/pickList/pickList.css')); ?>" rel="stylesheet" type="text/css">

    <link href="<?php echo e(asset('bower_components/select2/dist/css/select2.min.css')); ?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://rawgit.com/iamdanfox/anno.js/gh-pages/dist/anno.js" type="text/javascript"></script>
    <script src="https://rawgit.com/litera/jquery-scrollintoview/master/jquery.scrollintoview.js" type="text/javascript"></script>

    <link href="<?php echo e(asset('bower_components/anno.js/anno.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Custom Datepicker  -->
    <link href="<?php echo e(asset('libs/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo e(asset('libs/jquery-ui.css')); ?>" rel="stylesheet" type="text/css">

    <script src="<?php echo e(asset('libs/jquery-1.11.3.min.js')); ?>"></script>

    <script src="<?php echo e(asset('libs/bootstrap-datepicker.min.js')); ?>"></script>

    <!--Custom datatable-->
    <link href="<?php echo e(asset('libs/dataTables.min.css')); ?>" rel="stylesheet" type="text/css"/>

    <!--Custom charts-->
    <script src="<?php echo e(asset('libs/loader.js')); ?>"></script>
    <!--Custom qr-->
    <script src=<?php echo e(asset('libs/qrcode.js')); ?>></script>

    <!--Custom dropzone-->
    <link href="<?php echo e(asset('bower_components/dropzone/dist/min/dropzone.min.css')); ?>" rel="stylesheet" type="text/css">

    <script>
      function asset(url) {
        return '<?php echo e(asset('/')); ?>' + url;
      }
    </script>

    <script src="<?php echo e(asset('js/includes/main.js')); ?>"></script>
    <?php if(isset($js) && is_array($js)): ?>
      <?php foreach($js as $script): ?>
        <script src="<?php echo e(asset($script)); ?>"></script>
      <?php endforeach; ?>
    <?php endif; ?>
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('/uploads/favicon.png')); ?>"/>
</head>

<body>
