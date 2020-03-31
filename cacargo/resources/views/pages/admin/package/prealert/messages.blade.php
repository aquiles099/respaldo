<?php
use App\Models\Admin\Configuration;
    $configuration = Configuration::find(1);
    $lang = isset($configuration->language) ? $configuration->language : 'en';
 ?>
<script type='text/javascript'>
  var messages = {
    delete : "{!!trans('prealert.delete')!!}",
    language: '{!!$lang!!}'
  };
</script>
