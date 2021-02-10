@extends('backend/layout/base')

@section('body')
    <body class="app">
        @yield('content')
        <example-component></example-component>
        <!-- BEGIN: JS Assets-->
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="{{ mix('dist/js/app.js') }}"></script>
        <!-- END: JS Assets-->
    </body>
@endsection