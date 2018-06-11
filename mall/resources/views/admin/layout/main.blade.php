<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="/build/css/custom.min.css" rel="stylesheet">
    <!-- Bootstrap-fileinput -->
    <link href="/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet">
    <!--fileupload-->
    <link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="/fileupload/css/jquery.fileupload.css">
    <link rel="stylesheet" href="/fileupload/css/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="/fileupload/css/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="/fileupload/css/jquery.fileupload-ui-noscript.css"></noscript>


    <sctipt src="{{ URL::asset('/') }}vendors/jquery/dist/jquery.min.js"></sctipt>
    <script src="/vendors/jquery/dist/jquery.min.js"></script>
    <script src="/upload/upload.js"></script>

    <script src="/layer/layer.js"></script>
    {{--<script src="/vendors/echarts/dist/echarts.common.js"></script>--}}
    <script src="/echarts/echarts-all.js"></script>
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">

        @include("admin.layout.header")

        @include("admin.layout.sidebar")

        @yield("content")


    </div>
</div>
@include('admin.layout.footer')
<!-- jQuery -->

</body>
</html>

<!-- Bootstrap -->

<script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="https://cdn.bootcss.com/select2/4.0.6-rc.1/js/select2.min.js"></script>
<link href="https://cdn.bootcss.com/select2/4.0.6-rc.1/css/select2.css" rel="stylesheet">
<script src="/upload/util.js"></script>

<!-- FastClick -->
<script src="/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/vendors/nprogress/nprogress.js"></script>
<!-- iCheck -->
<script src="/vendors/iCheck/icheck.min.js"></script>
<!-- Chart.js -->
<script src="/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- jQuery Sparklines -->
<script src="/vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- Switchery -->
<script src="/vendors/switchery/dist/switchery.min.js"></script>
{{--<!-- Select2 -->
<script src="/vendors/select2/dist/js/select2.full.min.js"></script>--}}
<!-- Flot -->
<script src="/vendors/Flot/jquery.flot.js"></script>
<script src="/vendors/Flot/jquery.flot.pie.js"></script>
<script src="/vendors/Flot/jquery.flot.time.js"></script>
<script src="/vendors/Flot/jquery.flot.stack.js"></script>
<script src="/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="/vendors/DateJS/build/date.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="/vendors/moment/min/moment.min.js"></script>
<script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- Custom Theme Scripts -->
<script src="/build/js/custom.min.js"></script>
<script src="/js/require.js"></script>
<script src="/ueditor/ueditor.config.js"></script>
<script src="/ueditor/ueditor.all.js"></script>
<script src="/admin.js"></script>
