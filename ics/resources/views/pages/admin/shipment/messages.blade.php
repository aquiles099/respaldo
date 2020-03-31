<?php
use App\Models\Admin\Configuration;
    $configuration = Configuration::find(1);
    $code_users = $configuration->prefix;
    $lang = $configuration->language;
?>
<script type='text/javascript'>
  var messages = {
    delete : "{!!trans('shipment.delete')!!}",
    maritime_selected : "{!!trans('shipment.maritime_selected')!!}",
    aerial_selected : "{!!trans('shipment.aerial_selected')!!}",
    language : "{!!$lang!!}"
  };
</script>
