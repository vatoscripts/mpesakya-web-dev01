<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.auth.head')
</head>

<body>
    <div id="app" class="wrapper">
        <div class="block-center mt-4 wd-xl">
            @yield('content')

        </div>
        <footer class="row">
            @include('includes.auth.footer')
        </footer>

    </div>

</body>

@include('includes.auth.scripts')

</html>
