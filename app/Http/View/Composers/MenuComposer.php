<?php
/**
 *  app/Http/View/Composers/MenuComposer.php
 *
 * User:
 * Date-Time: 28.10.20
 * Time: 14:33
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Http\View\Composers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class MenuComposer
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $currentUrl = URL::current();
        $layout = Setting::where(['key' => 'active_menu'])->first();
        $view->with('menuItems', $this->menuItems())->with('layout', $layout->value);
    }

    public function menuItems()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'layout' => 'side-menu',
                'page_name' => 'dashboard',
                'title' => 'Dashboard',
                'route' => '',
                'permission' => ''
            ],
            'roles' => [
                'icon' => 'lock',
                'page_name' => 'roles',
                'title' => 'Roles',
                'route' => route('rolesIndex'),
                'permission' => ''
            ],
            'users' => [
                'icon' => 'users',
                'page_name' => 'users',
                'title' => 'Users',
                'route' => route('usersIndex'),
                'permission' => ''

            ],
            'departments' => [
                'icon' => 'globe',
                'page_name' => 'departments',
                'title' => 'Departments',
                'route' => route('departmentsIndex'),
                'permission' => 'read_department'
            ],
            'my_tickets' => [
                'icon' => 'file-text',
                'page_name' => 'My Tickets',
                'title' => 'My Tickets',
                'route' => route('ticketsIndex'),
                'permission' => ''
            ],
        ];

    }
}