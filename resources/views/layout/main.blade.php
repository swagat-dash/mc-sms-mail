@extends('../layout/base')

@section('body')
    <body class="app">
        @yield('content')

        <!-- BEGIN: JS Assets-->
        <script src="{{ asset('dist/js/app.js') }}"></script>
        <!-- END: JS Assets-->

        @yield('script')

    <script src="{{ filePath('assets/js/default.js') }}"></script>

    <script src="{{ filePath('assets/js/sweetalert2@10.js') }}"></script>

       @if ($errors->any())
            <script src="{{ filePath('bladejs/error-alert.js') }}"></script>
        @endif

    </body>
@endsection