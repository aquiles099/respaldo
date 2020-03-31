<?php
    use App\Models\Admin\Configuration;

    $configuration = Configuration::find(1);
    $lang = $configuration->language;
 ?>
<script type='text/javascript'>
  var messages = {
    delete : "<?php echo trans('transportType.delete'); ?>",
    language : "<?php echo $lang; ?>"
  };
</script>