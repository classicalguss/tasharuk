<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    //
//	  DB::listen(function($query) {
//		  Log::info(
//			  $query->sql,
//			  [
//				  'bindings' => $query->bindings,
//				  'time' => $query->time
//			  ]
//		  );
//	  });
  }
}
