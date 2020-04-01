<?php
    use App\Models\Admin\Configuration;

    $configuration = Configuration::find(1);
    $lang = $configuration->language;
    App::setLocale($lang);

 ?>
