@extends('backend/layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('backend/layout/components/mobile-menu')
    <div class="flex">
        <!-- BEGIN: Simple Menu -->
        <nav class="side-nav side-nav--simple">
            <a href="/" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Investgroup" class="w-25"
                     src="{{ asset('logo.svg') }}">
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                @foreach ($menuItems as $menu)
                    @if ($menu == 'devider')
                        <li class="side-nav__devider my-6"></li>
                    @else
                        <li>
                            <a href="{{$menu['route']}}"
                               class="side-menu">
                                <div class="side-menu__icon">
                                    <i data-feather="{{ $menu['icon'] }}"></i>
                                </div>
                                <div class="side-menu__title">
                                    {{ $menu['title'] }}
                                    @if (isset($menu['sub_menu']))
                                        <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                                    @endif
                                </div>
                            </a>
                            @if (isset($menu['sub_menu']))
                                <ul class="">
                                    @foreach ($menu['sub_menu'] as $subMenu)
                                        <li>
                                            <a href="{{$menu['route']}}"
                                               class="side-menu">
                                                <div class="side-menu__icon">
                                                    <i data-feather="activity"></i>
                                                </div>
                                                <div class="side-menu__title">
                                                    {{ $subMenu['title'] }}
                                                    @if (isset($subMenu['sub_menu']))
                                                        <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                                                    @endif
                                                </div>
                                            </a>
                                            @if (isset($subMenu['sub_menu']))
                                                <ul class="{{ $second_page_name == $subMenu['page_name'] ? 'side-menu__sub-open' : '' }}">
                                                    @foreach ($subMenu['sub_menu'] as $lastSubMenu)
                                                        <li>
                                                            <a href="{{$lastSubMenu['route']}}">
                                                                <div class="side-menu__icon">
                                                                    <i data-feather="zap"></i>
                                                                </div>
                                                                <div class="side-menu__title">{{ $lastSubMenu['title'] }}</div>
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
                    @endif
                @endforeach
            </ul>
        </nav>
        <!-- END: Simple Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            @include('backend/layout/components/top-bar')
            @include('.backend.layout.alerts')
            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>
@endsection