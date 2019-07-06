<!DOCTYPE html>
<html>
<head>
    <meta name="robots" content="noindex">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo (isset($headTitle)? $headTitle . ' • ' : null).asw('title') ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('headBefore')
  <link rel="stylesheet" href="{{ url('panel/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('panel/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ url('panel/bower_components/Ionicons/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ url('panel/dist/css/main.min.css') }}">
  <link rel="stylesheet" href="{{ url('panel/dist/css/skins/skin-blue.min.css') }}">
  <link rel="stylesheet" href="{{ url('panel/plugins/fancybox/jquery.fancybox.min.css') }}">
  <link rel="stylesheet" href="{{ url('panel/dist/css/custom.css') }}">
  <link rel="stylesheet" href="{{ url('panel/plugins/iCheck/square/blue.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
@yield('headAfter')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="pageLoader"><span><?php echo isset($headTitle)? $headTitle : 'Yükleniyor...'; ?></span></div>
<div class="wrapper">

@include("panel/inc/main_header")
@include("panel/inc/main_sidebar")


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @hasSection("pageTitle")
    <section class="content-header">
      <h1>
        @yield("pageTitle")
        @hasSection("pageDescription")<small>@yield("pageDescription")</small>@endif
      </h1>
      <?php /*
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
      */ ?>
  </section>
    @endif

    <!-- Main content -->
    <section class="content container-fluid">
         @yield("content")
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<input type="hidden" id="ajaxImageUploadUrl" value="{{ route('panel.ajax.image.upload') }}">
<script src="{{ url('panel/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('panel/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('panel/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ url('panel/dist/js/main.min.js') }}"></script>
<script src="{{ url('panel/dist/js/custom.js') }}"></script>
<input type="hidden" id="mediaBoxUrl" value="{{ route('panel.ajax.media.box') }}"/>
<link rel="stylesheet" href="{{ url('panel/plugins/media-popup/style.css') }}" />
<script src="{{ url('panel/plugins/media-popup/script.js') }}"></script>
<script src="{{ url('panel/plugins/fancybox/jquery.fancybox.min.js') }}"></script>
@yield('end')
<script>window.onload = function(){ document.getElementById('pageLoader').remove(); }</script>
</body>
</html>
