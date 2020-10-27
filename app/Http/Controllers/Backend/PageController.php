<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;

class PageController extends BackendController
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function loadPage($layout = 'side-menu', $pageName = 'dashboard')
    {
        $activeMenu = $this->activeMenu($layout, $pageName);
        return view('backend/module/' . $pageName, [
            'top_menu' => $this->topMenu(),
            'side_menu' => $this->sideMenu(),
            'simple_menu' => $this->simpleMenu(),
            'first_page_name' => $activeMenu['first_page_name'],
            'second_page_name' => $activeMenu['second_page_name'],
            'third_page_name' => $activeMenu['third_page_name'],
            'layout' => $layout
        ]);
    }

    /**
     * Determine active menu & submenu.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Http\Response|string[]
     */
    public function activeMenu($layout, $pageName)
    {
        $firstPageName = '';
        $secondPageName = '';
        $thirdPageName = '';

        if ($layout == 'top-menu') {
            foreach ($this->topMenu() as $menu) {
                if ($menu['page_name'] == $pageName && empty($firstPageName)) {
                    $firstPageName = $menu['page_name'];
                }

                if (isset($menu['sub_menu'])) {
                    foreach ($menu['sub_menu'] as $subMenu) {
                        if ($subMenu['page_name'] == $pageName && empty($secondPageName) && $subMenu['page_name'] != 'dashboard') {
                            $firstPageName = $menu['page_name'];
                            $secondPageName = $subMenu['page_name'];
                        }

                        if (isset($subMenu['sub_menu'])) {
                            foreach ($subMenu['sub_menu'] as $lastSubmenu) {
                                if ($lastSubmenu['page_name'] == $pageName) {
                                    $firstPageName = $menu['page_name'];
                                    $secondPageName = $subMenu['page_name'];
                                    $thirdPageName = $lastSubmenu['page_name'];
                                }       
                            }
                        }
                    }
                }
            }
        } else if ($layout == 'simple-menu') {
            foreach ($this->simpleMenu() as $menu) {
                if ($menu !== 'devider' && $menu['page_name'] == $pageName && empty($firstPageName)) {
                    $firstPageName = $menu['page_name'];
                }

                if (isset($menu['sub_menu'])) {
                    foreach ($menu['sub_menu'] as $subMenu) {
                        if ($subMenu['page_name'] == $pageName && empty($secondPageName) && $subMenu['page_name'] != 'dashboard') {
                            $firstPageName = $menu['page_name'];
                            $secondPageName = $subMenu['page_name'];
                        }

                        if (isset($subMenu['sub_menu'])) {
                            foreach ($subMenu['sub_menu'] as $lastSubmenu) {
                                if ($lastSubmenu['page_name'] == $pageName) {
                                    $firstPageName = $menu['page_name'];
                                    $secondPageName = $subMenu['page_name'];
                                    $thirdPageName = $lastSubmenu['page_name'];
                                }       
                            }
                        }
                    }
                }
            }
        } else {
            foreach ($this->sideMenu() as $menu) {
                if ($menu !== 'devider' && $menu['page_name'] == $pageName && empty($firstPageName)) {
                    $firstPageName = $menu['page_name'];
                }

                if (isset($menu['sub_menu'])) {
                    foreach ($menu['sub_menu'] as $subMenu) {
                        if ($subMenu['page_name'] == $pageName && empty($secondPageName) && $subMenu['page_name'] != 'dashboard') {
                            $firstPageName = $menu['page_name'];
                            $secondPageName = $subMenu['page_name'];
                        }

                        if (isset($subMenu['sub_menu'])) {
                            foreach ($subMenu['sub_menu'] as $lastSubmenu) {
                                if ($lastSubmenu['page_name'] == $pageName) {
                                    $firstPageName = $menu['page_name'];
                                    $secondPageName = $subMenu['page_name'];
                                    $thirdPageName = $lastSubmenu['page_name'];
                                }       
                            }
                        }
                    }
                }
            }
        }

        return [
            'first_page_name' => $firstPageName,
            'second_page_name' => $secondPageName,
            'third_page_name' => $thirdPageName
        ];
    }

    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function sideMenu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'layout' => 'side-menu',
                'page_name' => 'dashboard',
                'title' => 'Dashboard',
                'route' => ''
            ],
            'menu-layout' => [
                'icon' => 'box',
                'page_name' => 'menu-layout',
                'title' => 'Menu Layout',
                'sub_menu' => [
                    'side-menu' => [
                        'icon' => '',
                        'layout' => 'side-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Side Menu'
                    ],
                    'simple-menu' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Simple Menu'
                    ],
                    'top-menu' => [
                        'icon' => '',
                        'layout' => 'top-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Top Menu'
                    ]
                ]
            ]
        ];
    }

    /**
     * List of simple menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function simpleMenu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'layout' => 'simple-menu',
                'page_name' => 'dashboard',
                'title' => 'Dashboard'
            ],
            'menu-layout' => [
                'icon' => 'box',
                'page_name' => 'menu-layout',
                'title' => 'Menu Layout',
                'sub_menu' => [
                    'side-menu' => [
                        'icon' => '',
                        'layout' => 'side-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Side Menu'
                    ],
                    'simple-menu' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Simple Menu'
                    ],
                    'top-menu' => [
                        'icon' => '',
                        'layout' => 'top-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Top Menu'
                    ]
                ]
            ],
        ];
    }

    /**
     * List of top menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function topMenu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'layout' => 'top-menu',
                'page_name' => 'dashboard',
                'title' => 'Dashboard'
            ],
            'menu-layout' => [
                'icon' => 'box',
                'page_name' => 'menu-layout',
                'title' => 'Menu Layout',
                'sub_menu' => [
                    'side-menu' => [
                        'icon' => '',
                        'layout' => 'side-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Side Menu'
                    ],
                    'simple-menu' => [
                        'icon' => '',
                        'layout' => 'simple-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Simple Menu'
                    ],
                    'top-menu' => [
                        'icon' => '',
                        'layout' => 'top-menu',
                        'page_name' => 'dashboard',
                        'title' => 'Top Menu'
                    ]
                ]
            ],
        ];
    }
}
