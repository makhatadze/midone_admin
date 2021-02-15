<!DOCTYPE html>
<!--
Template Name: Midone - Laravel Admin Dashboard Starter Kit
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8">
    <link href="{{ asset('logo.svg') }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">


@yield('head')

<!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}"/>
    <link rel="stylesheet" href="{{ asset('../css/fonts.css') }}" />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->
@yield('body')

</html>