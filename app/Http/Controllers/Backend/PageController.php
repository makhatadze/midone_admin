<?php
/**
 *  app/Http/Controllers/Backend/PageController.php
 *
 * User:
 * Date-Time: 09.11.20
 * Time: 11:30
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\Menu;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;

class PageController extends BackendController
{
    /**
     * Show specified view.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function loadPage($layout = 'side-menu', $pageName = 'dashboard')
    {
        return redirect('admin/tickets');
    }

    /**
     * Show specified view.
     *
     * @param String $activeMenu
     *
     * @return RedirectResponse
     */
    public function activeMenu(string $activeMenu)
    {
        if ($activeMenu == 'side-menu' || $activeMenu == 'top-menu' || $activeMenu == 'simple-menu') {
            $menu = Menu::where('user_id', auth()->user()->id)->first();
            $menu->name = $activeMenu;
            $menu->save();
            return back()->with('success', 'Active menu changed successfully');
        }

        return back()->with('danger', 'Not exist this menu');


    }
}
