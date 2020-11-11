@extends('backend/layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('backend/layout/components/mobile-menu')
    <!-- BEGIN: Top Bar -->
    <div class="border-b border-theme-24 -mt-10 md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 pt-3 md:pt-0 mb-10">
        <div class="top-bar-boxed flex items-center">
            <!-- BEGIN: Logo -->
            <a href="" class="-intro-x hidden md:flex">
                <img alt="Midone Laravel Admin Dashboard Starter Kit" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                <span class="text-white text-lg ml-3">
                    Mid<span class="font-medium">one</span>
                </span>
            </a>
            <!-- END: Logo -->
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb breadcrumb--light mr-auto">
                <a href="" class="">Application</a>
                <i data-feather="chevron-right" class="breadcrumb__icon"></i>
                <a href="" class="breadcrumb--active">Dashboard</a>
            </div>

            <!-- END: Search -->
            <!-- BEGIN: Notifications -->
            <div class="intro-x dropdown mr-3">
                <div class="dropdown-toggle w-36 h-8 ">
                    <button class="dropdown-toggle button inline-block bg-theme-2 text-gray-700">Select Menu</button>
                </div>
                <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                    @if($activeMenu == 'side-menu')
                        <a href="{{route('activeMenu',['activeMenu' => 'simple-menu'])}}"
                           class="block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Simple
                            Menu</a>
                        <a href="{{route('activeMenu','top-menu')}}"
                           class="block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Top
                            Menu</a></div>
                @elseif($activeMenu == 'simple-menu')
                    <a href="{{route('activeMenu',['activeMenu' => 'side-menu'])}}"
                       class="block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Side
                        Menu</a>
                    <a href="{{route('activeMenu',['activeMenu' => 'top-menu'])}}"
                       class="block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Top
                        Menu</a></div>
            @elseif($activeMenu == 'top-menu')
                <a href="{{route('activeMenu',['activeMenu' => 'side-menu'])}}"
                   class="block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Side
                    Menu</a>
                <a href="{{route('activeMenu',['activeMenu' => 'simple-menu'])}}"
                   class="block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Simple
                    Menu</a>
            @endif
        </div>
        <div class="intro-x dropdown w-8 h-8 relative">
            <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110">
                <img alt="Midone Laravel Admin Dashboard Starter Kit"
                     src="{{ asset('dist/images/' . $fakers[9]['photos'][0]) }}">
            </div>
            <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                <div class="dropdown-box__content box bg-theme-38 text-white">
                    <div class="p-4 border-b border-theme-40">
                        <div class="font-medium">{{ $loggedin_user->name }}</div>
                    </div>
                    <div class="p-2 border-t border-theme-40">
                        <a href="{{ route('logout') }}"
                           class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md">
                            <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Notifications -->
    <!-- BEGIN: Account Menu -->

    <!-- END: Account Menu -->
    </div>
    </div>
    <!-- END: Top Bar -->
    <!-- BEGIN: Top Menu -->
    <nav class="top-nav">
        <ul>
            @foreach ($menuItems as $menu)
                <li>
                    <a href="{{ isset($menu['layout']) ? route('page', ['layout' => $menu['layout'], 'pageName' => $menu['page_name']]) : 'javascript:;' }}"
                       class="top-menu">
                        <div class="top-menu__icon">
                            <i data-feather="{{ $menu['icon'] }}"></i>
                        </div>
                        <div class="top-menu__title">
                            {{ $menu['title'] }}
                            @if (isset($menu['sub_menu']))
                                <i data-feather="chevron-down" class="top-menu__sub-icon"></i>
                            @endif
                        </div>
                    </a>
                    @if (isset($menu['sub_menu']))
                        <ul class="">
                            @foreach ($menu['sub_menu'] as $subMenu)
                                <li>
                                    <a href="{{ isset($subMenu['layout']) ? route('page', ['layout' => $subMenu['layout'], 'pageName' => $subMenu['page_name']]) : 'javascript:;' }}" class="top-menu">
                                        <div class="top-menu__icon">
                                            <i data-feather="activity"></i>
                                        </div>
                                        <div class="top-menu__title">
                                            {{ $subMenu['title'] }}
                                            @if (isset($subMenu['sub_menu']))
                                                <i data-feather="chevron-down" class="top-menu__sub-icon"></i>
                                            @endif
                                        </div>
                                    </a>
                                    @if (isset($subMenu['sub_menu']))
                                        <ul class="">
                                            @foreach ($subMenu['sub_menu'] as $lastSubMenu)
                                                <li>
                                                    <a href="{{ isset($lastSubMenu['layout']) ? route('page', ['layout' => $lastSubMenu['layout'], 'pageName' => $lastSubMenu['page_name']]) : 'javascript:;' }}" class="top-menu">
                                                        <div class="top-menu__icon">
                                                            <i data-feather="zap"></i>
                                                        </div>
                                                        <div class="top-menu__title">{{ $lastSubMenu['title'] }}</div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
    <!-- END: Top Menu -->
    <!-- BEGIN: Content -->
    @include('.backend.layout.alerts')

    <div class="content">
        @yield('subcontent')
    </div>
    <!-- END: Content -->
@endsection