<!DOCTYPE html>
<html>
<head>
        <meta name="robots" content="noindex">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ASWEB Kurulum</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ url('panel/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{ url('panel/dist/css/main.min.css') }}">
  <link rel="stylesheet" href="{{ url('panel/dist/css/skins/skin-blue.min.css') }}">
  <link rel="stylesheet" href="{{ url('panel/plugins/iCheck/square/blue.css') }}">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
.setup-box{ width: 400px;   margin: 7% auto;    }
.box-body{padding:20px;}
.box-header{ border-bottom: 1px solid #f4f4f4; padding: 10px; }
</style>
</head>
<body class="hold-transition login-page" style="height: auto;">
<?php echo getAlert("fixed"); ?>
<div class="setup-box">
    @yield('content')
</div>
<script src="{{ url('panel/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('panel/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('panel/plugins/iCheck/icheck.min.js') }}"></script>
@yield('end')
<script src="{{ url('panel/plugins/fancybox/jquery.fancybox.min.js') }}"></script>
<script src="{{ url('panel/dist/js/custom.js') }}"></script>
</body>
</html>
