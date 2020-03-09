<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);


        // Directives to handle admin check
        Blade::directive('admin', function(){
            return "<?php if(auth()->user()->admin): ?>";
        });

        Blade::directive('endadmin', function(){
            return "<?php endif; ?>";
        });

        // Directives to handle grower check
        Blade::directive('grower', function(){
            return "<?php if(!is_null(auth()->user()->grower)): ?>";
        });

        Blade::directive('endgrower', function(){
            return "<?php endif; ?>";
        });

        // Directives to handle customer check
        Blade::directive('customer', function(){
            return "<?php if(!is_null(auth()->user()->customer)): ?>";
        });

        Blade::directive('endcustomer', function(){
            return "<?php endif; ?>";
        });


    }
}
