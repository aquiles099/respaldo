<?php
    use App\Models\Admin\Configuration;

    $configuration = Configuration::find(1);
    $lang = $configuration->language;
 ?>
<script type='text/javascript'>
  var messages = {
    delete : "{!!trans('pickup.delete')!!}",
    language : "{!!$lang!!}"
  };
</script>
