<?php

namespace App\Http\View\Composers;

use App\Faker;
use App\Models\Setting;
use Illuminate\View\View;

class LoggedInUserComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $activeMenu = Setting::where('key', 'active_menu')->first();

        $view->with('loggedin_user', request()->user())->with('activeMenu', $activeMenu->value);
    }
}