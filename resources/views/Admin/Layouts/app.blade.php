<!DOCTYPE html>
<html lang="en">
@include('Admin.Layouts.header')
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <script type="text/javascript" style="display:none">
                //<![CDATA[
                window.__mirage2 = {
                    petok: "4zJ_niCVMaRg4No.jBAYnNhRIP5CEhJ9XKGcdjHhpHQ-14400-0.0.1.1"
                };
                //]]>
            </script>
            <script type="text/javascript"
                src="{{ asset('backend/admin/dist/js/mirage2.min.js') }}"></script>
            <img class="animation__shake" alt="AdminLTELogo" height="60" width="60"
                data-cfsrc="{{ asset('backend/admin/dist/img/AdminLTELogo.png') }}" style="display:none;visibility:hidden;"><noscript><img
                    class="animation__shake" src="{{ asset('backend/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60"
                    width="60"></noscript>
        </div>

        <!-- Navbar -->
        @include('Admin.Layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('Admin.Layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022-2025 <a href="https://bestdreamcar.com">Best Dream Car</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @include('Admin.Layouts.footer')
    @stack('scripts')
</body>

</html>
