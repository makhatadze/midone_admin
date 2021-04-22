<?php

namespace App\Http\View\Composers;

use App\Faker;
use App\Models\Menu;
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
        $loggedinUser = request()->user();
        $activeMenu = null;
        if ($loggedinUser) {
            $activeMenu = Menu::where('user_id', $loggedinUser->id)->first();
        }

        $view->with('loggedin_user', $loggedinUser)->with('activeMenu', $activeMenu->name ?? null);
    }
}