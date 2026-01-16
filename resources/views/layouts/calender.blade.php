<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        @yield('title', 'CMCU')
    </title>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <!-- Bootstrap 5 CSS is loaded via Vite in app.scss -->
    <link rel="stylesheet" href="{{ asset('admin/css/bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fullcalendar-2.2.7.min.css') }}">
    <link href="{{ asset('login.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="{{ asset('admin/css/style4.css') }}">
    <link href="{{ asset('admin/css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/poiret-one.css') }}" rel='stylesheet' type='text/css'>
    <link href="{{ asset('fonts/open-sans.css') }}" rel='stylesheet' type='text/css'>

@yield('content')


<script src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>
<script src="{{ asset('js/moment-2.9.0.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar-2.2.7.min.js') }}"></script>
<script src='{{ asset('admin/js/jquery-2.2.3.min.js') }}'></script>
<script>
    $(window).load(function () {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");;
    });
</script>

<script>
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
</script>

<!-- profile-widget-dropdown js-->
<script src="{{ asset('admin/js/script.js') }}"></script>
<!--// profile-widget-dropdown js-->


<!-- dropdown nav -->
<script>
    $(document).ready(function () {
        $(".dropdown").hover(
            function () {
                $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                $(this).toggleClass('open');
            },
            function () {
                $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                $(this).toggleClass('open');
            }
        );
    });
</script>
<!-- //dropdown nav -->

<!-- Js for bootstrap working-->
<script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
<!-- //Js for bootstrap working -->

</html>
