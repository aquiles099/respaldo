<?phpuse App\Models\Admin\Configuration;    /**    * Se asigna logo al sistema    */    $configuration = Configuration::find(1);    $code_users = $configuration->prefix;
    $lang = $configuration->language;?><script type='text/javascript'>  var messages = {    delete : "{!!trans('package.delete')!!}",    imp_medition : "{!!trans('package.imp_medition')!!}",    int_medition : "{!!trans('package.int_medition')!!}",    code: "{!!($code_users)!!}",    language : "{!!$lang!!}"  };
</script>
