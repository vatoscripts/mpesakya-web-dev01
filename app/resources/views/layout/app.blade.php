<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.dashboard.head')
</head>

<body>
    <div class="wrapper" id="app">
        <!-- top navbar-->
        <header class="topnavbar-wrapper">
            <!-- START Top Navbar-->
            @include('includes.dashboard.navbar')

            <!-- END Top Navbar-->
        </header>
        <!-- sidebar-->
        <aside class="aside-container">
            <!-- START Sidebar (left)-->
            <div class="aside-inner">
                @include('includes.dashboard.sidebar')

            </div>
            <!-- END Sidebar (left)-->
        </aside>
        <!-- offsidebar-->

        <!-- Main section-->
        @yield('content')


        <div class="flex-center position-ref full-height">
            <div class="code">
                @yield('code')
            </div>

            <div class="message" style="padding: 10px;">
                @yield('message')
            </div>
        </div>
        <!-- Page footer-->
        <footer class="footer-container">
            <span>&COPY;<?php echo date("Y"); ?> M-pesa Limited</span>
        </footer>
    </div>
    @include('includes.dashboard.scripts')

</body>

</html>
