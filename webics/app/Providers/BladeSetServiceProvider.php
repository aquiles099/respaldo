<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeSetServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
      $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();
      $blade->extend( function($value, $compiler) {
          $value = preg_replace("/@set\('(.*?)'\,(.*)\)/", '<?php $$1 = $2; ?>', $value);
          $value = preg_replace("/@set\('(.*?)'\)/", '<?php $$1 = \'$1\'; ?>', $value);
          return $value;
      });
    }
}
