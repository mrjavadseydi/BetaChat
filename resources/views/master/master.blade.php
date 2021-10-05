<!DOCTYPE html>
<html>
<head>
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
    <div name="destroy" content="{{ csrf_token() }}"></div>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>صفحه شخصی مدیریت</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/dist/css/adminlte.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/dist/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/dist/css/custom-style.css">
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/dist/css/persian-datepicker.min.css">
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="{{asset('AdminAsset/')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!----data table----->
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/datatables.css')}}"/>
    <style>
        .dt-buttons {
            float: left;
            padding: 10px;
        }

        .dt-buttons button {
            margin: 3px;
        }
        #akbari{
            position: fixed;
            background: white;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            z-index: 9999999;
        }
        #preloader {
            z-index: 100000;
            position: relative !important;
            transform: translate(48%, 68%);
            top: 350px;
        }

        #preloader span {
            display: block;
            bottom: 0px;
            width: 9px;
            height: 5px;
            background: #9b59b6;
            position: absolute;
            animation: preloader 1.5s infinite ease-in-out;
        }

        #preloader span:nth-child(2) {
            left: 11px;
            animation-delay: .2s;

        }

        #preloader span:nth-child(3) {
            left: 22px;
            animation-delay: .4s;
        }

        #preloader span:nth-child(4) {
            left: 33px;
            animation-delay: .6s;
        }

        #preloader span:nth-child(5) {
            left: 44px;
            animation-delay: .8s;
        }

        @keyframes preloader {
            0% {
                height: 5px;
                transform: translateY(0px);
                background: #9b59b6;
            }
            25% {
                height: 30px;
                transform: translateY(15px);
                background: #3498db;
            }
            50% {
                height: 5px;
                transform: translateY(0px);
                background: #9b59b6;
            }
            100% {
                height: 5px;
                transform: translateY(0px);
                background: #9b59b6;
            }
        }
        .red-star{
            color: red;
        }
        .w-99{
            max-width:99%;
        }
    </style>
    <script src="{{asset('AdminAsset/')}}/plugins/jquery/jquery.min.js"></script>

</head>
<body class="hold-transition sidebar-mini">
<div id="akbari">
    <div id="preloader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('panel')}}" class="nav-link">خانه</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->

        <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto">
            <!-- Messages Dropdown Menu -->
            <!-- Notifications Dropdown Menu -->

        </ul>
        <form action="{{route('logout')}}" method="post">
            @csrf
            <button type="submit" class="text-left" style="background:#f1f1f16b;border:0;cursor: pointer;">
              <span>
                    خروج
              </span>
                <i class="fa fa-sign-out" aria-hidden="true"></i>

            </button>

        </form>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
            {{--            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"--}}
            {{--                 style="opacity: .8">--}}
            <span class="brand-text font-weight-light">صفحه شخصی مدیریت</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar" style="direction: ltr">
            <div style="direction: rtl">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        {{--                        <img src="https://www.birjand.ac.ir/assets/bb2b6f/images/logo-arm.png" class="img-circle elevation-2" alt="User Image">--}}
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            {{auth()->user()->name}}

                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                @include('master.sidebar')
                <!-- /.sidebar-menu -->
            </div>
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @yield('position')
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
            @yield('content')
            <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>تمامی حقوق مادی و معنوی سایت محفوظ است</strong>

    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<!-- jQuery UI 1.11.4 -->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('AdminAsset/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('AdminAsset/')}}/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="{{asset('AdminAsset/')}}/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="{{asset('AdminAsset/')}}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{asset('AdminAsset/')}}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('AdminAsset/')}}/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{asset('AdminAsset/')}}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="{{asset('AdminAsset/')}}/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('AdminAsset/')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="{{asset('AdminAsset/')}}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{asset('AdminAsset/')}}/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminAsset/')}}/dist/js/adminlte.js"></script>
<script src="{{asset('js/app.js')}}"></script>

<!---select2-->
<script src="{{asset('AdminAsset/')}}/plugins/select2/select2.min.js"></script>
@yield('script')
<script>
    $(document).ready(function () {

        $('#preloader').remove();
        $('#akbari').css('display', 'none');
    });

</script>


@include('sweetalert::alert')
</body>
</html>
