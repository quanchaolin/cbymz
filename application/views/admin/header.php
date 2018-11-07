<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=get_admin_config('site_title')?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/bootstrap/dist/css/bootstrap.min.css')?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/font-awesome/css/font-awesome.min.css')?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/Ionicons/css/ionicons.min.css')?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/select2/dist/css/select2.min.css')?>">
    <!-- bootstrap-dialog -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-dialog/dist/css/bootstrap-dialog.min.css')?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/AdminLTE/css/AdminLTE.min.css')?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/AdminLTE/css/skins/_all-skins.min.css')?>">
    <!-- Pace style -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/pace/pace.min.css')?>">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/iCheck/all.css')?>">
    <!---parsley.css--->
    <link href="<?=base_url('static/plugins/parsleyjs/src/parsley.css')?>" rel="stylesheet" type="text/css" />
    <!-- custom -->
    <link rel="stylesheet" href="<?=base_url('static/css/custom.css')?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="javascript:void(0);" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>CW</b>FP</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?=get_admin_config('site_name')?></b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning message-count"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">您有<b class="message-count"></b>个通知</li>
                            <li>
                                <ul class="menu" id="nav-message">

                                </ul>
                            </li>
                            <li class="footer"><a href="<?=site_url('admin/message/index/')?>">查看全部消息</a></li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?=$this->admin['head_img_url']?>" class="user-image" alt="用户头像">
                            <span class="hidden-xs"><?=$this->admin['username']?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?=$this->admin['head_img_url']?>" class="img-circle" alt="用户头像">

                                <p>
                                    <?=$this->admin['username']?>
                                    <small><?=$this->admin['true_name']?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <!--<div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">追随者</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">销售额</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">朋友</a>
                                    </div>
                                </div>-->
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?=site_url('admin/profile/index/')?>" class="btn btn-default btn-flat">简况</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?=site_url('admin/common/login_out/')?>" class="btn btn-default btn-flat">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <script id="messageTemplate" type="x-tmpl-mustache">
    {{#messageList}}
        <li>
            <a href="{{showUrl}}">
                <i class="fa fa-bell-o text-aqua"></i>{{title}}
            </a>
        </li>
    {{/messageList}}
</script>
   <?php $this->load->view('admin/left_side.php');?>
