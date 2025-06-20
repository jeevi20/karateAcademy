<!DOCTYPE html>
<html lang="en">

<head>
@include('layouts/admin/_meta')
@include('layouts/admin/_style')

@livewireStyles

<title>{{ config('app.name') }} - Northern Province</title>
 
</head>

<body id="page-top">

    <div id="wrapper">

        @include('layouts/admin/_sidebar')
            <div id="content-wrapper" class="d-flex flex-column">

                    <div id="content">

                        @include('layouts/admin/_header')

                        <div class="container-fluid">

                        
                        @yield('css')
                        @yield('header')
                        @yield('content')
                        @livewireScripts
                        </div>
                    </div>

                    @include('layouts/admin/_footer')

            </div>
            
    </div>
    @include('layouts/admin/_logoutmodel')
    @include('layouts/admin/_script')

    @yield('js')

</body>

</html>