<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ URL::asset('/images/logo.png') }}" type="image/x-icon"/>

        <title>@yield('title', 'Drug Market')</title>

        {{-- AdminLTE Styles & Scripts --}}
        @include('includes.head')

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            
            {{-- Header & Sidebar --}}
            <div class="min-h-screen bg-gray-100">

                @include('includes.navigation-menu')
            
            </div>
                
            {{-- Main content --}}
            <div class="content-wrapper">

                @yield('content')    

            </div>
        
            @include('includes.footer')
        </div>

    </body>
    </html>
