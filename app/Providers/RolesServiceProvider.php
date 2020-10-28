<?php
/**
 *  app/Providers/RolesServiceProvider.php
 *
 * User:
 * Date-Time: 28.10.20
 * Time: 10:20
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Providers;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('role', function ($roles) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($roles)) : ?>"; //return this if statement inside php tag
        });

        Blade::directive('endrole', function ($roles) {
            return "<?php endif; ?>"; //return this endif statement inside php tag
        });
    }
}