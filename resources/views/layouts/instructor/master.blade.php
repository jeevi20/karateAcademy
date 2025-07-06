<!DOCTYPE html>
<html lang="en">

<head>
<!--Iinclude meta tag and the head content -->
@include('layouts/admin/_meta')

<!-- Include stylesheet links CSS -->
@include('layouts/admin/_style')

<!-- Load liveware styles -->
 @livewireStyles

</head>

<!-- Body section starts -->
<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar navigation  -->
        @include('layouts/instructor/_sidebar')
            <div id="content-wrapper" class="d-flex flex-column">

                    <div id="content">

                        <!-- Top navigation bar/header -->
                        @include('layouts/branchstaff/_header')

                        <div class="container-fluid">

                        <!-- Section to allow page-specific CSS  -->
                        @yield('css')
                        <!-- Section for optional page-specific header -->
                        @yield('header')
                        <!-- Main Page Content -->
                        @yield('content')
                        <!-- load livewire scripts if used -->
                        @livewireScripts

                        </div> 
                    </div>
                    <!-- footer section -->
                    @include('layouts/admin/_footer')

            </div>
            
    </div>
    <!-- Iclude Logout Module -->
    @include('layouts/admin/_logoutmodel')

    <!-- Include scripts (JS) -->
    @include('layouts/admin/_script')

    <!-- Page specific Javascript section -->
    @yield('js')

</body>

</html>