<?php
    use App\Models\Admin\Configuration;

    $configuration = Configuration::find(1);
    $lang = isset($configuration->language) ? $configuration->language : 'en';
    App::setLocale($lang);

 ?>
