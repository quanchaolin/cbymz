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
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/AdminLTE/css/AdminLTE.min.css')?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=base_url('static/plugins/iCheck/square/blue.css')?>">
    <!---bootstrap-dialog.css--->
    <link href="<?=base_url('static/plugins/bootstrap-dialog/dist/css/bootstrap-dialog.min.css')?>" rel="stylesheet" type="text/css" />
    <!---bootstrap-dialog.css--->
    <link href="<?=base_url('static/plugins/parsleyjs/src/parsley.css')?>" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?=get_admin_config('site_name')?></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">登录即可开始会话</p>
        <form id="form"  method="post" action="<?=site_url('admin/common/check_login?redirect_uri='.$redirect_uri)?>" data-parsley-validate="" >
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" value="<?=$login_info['username']?>" placeholder="用户名" data-parsley-required="true" data-parsley-required-message="用户名不可为空"/>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" value="<?=$login_info['password']?>" placeholder="密码" data-parsley-required="true" data-parsley-required-message="密码不可为空" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <?php if($yzm_open==1):?>
                <div class="form-group">
                    <div class="col-md-6" style="padding-left: 0">
                        <input type="text" name="checkcode" class="form-control" placeholder="验证码" data-parsley-required="true" data-parsley-required-message="验证码不可为空" autocomplete="off" />
                    </div>
                    <div class="col-md-3">
                   <span style="font-size:12px;"> <img id="img" src="<?=site_url('admin/common/checkcode/')?>" alt="验证码" />
   <a href="javascript:void(0)" onclick="reimg()">刷新</a></span>
                    </div>
                </div>
            <?php endif;?>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" value="1"> 记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <!-- /.social-auth-links -->

        <!--<a href="#">我忘记了我的密码</a><br>
        <a href="#" class="text-center">注册一个新的成员</a>-->

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?=base_url('static/plugins/jquery/dist/jquery.min.js')?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('static/plugins/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<!-- iCheck -->
<script src="<?=base_url('static/plugins/iCheck/icheck.min.js')?>"></script>
<!-- Parsley -->
<script src="<?=base_url('static/plugins/parsleyjs/dist/parsley.min.js')?>"></script>
<!-- bootstrap-dialog -->
<script src="<?=base_url('static/plugins/bootstrap-dialog/dist/js/bootstrap-dialog.min.js')?>"></script>
<script type="application/javascript" src="<?=base_url('static/js/dialog.js')?>"></script>
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<script>
    $(function () {
        var yzm_open=<?=$yzm_open?>;
        $('#form').parsley().on('form:validated', function() {
            var ok = $('.parsley-error').length === 0;
            if(ok)
            {
                var $form = $("#form")
                    ,url=$form.attr('action')
                    ,data=serializeForm($form);
                $.ajax({
                    type: 'POST',
                    dataType:"json",
                    url:  url,
                    data: data,
                    beforeSend:function(){
                        $('.btn-flat').attr('disabled','disabled').text('登录中...');
                    },
                    complete:function(){
                        $('.btn-flat').removeAttr('disabled').text('登录');
                    },
                    success: function(res) {
                        if (res.errcode==0) {
                            $.showSuccessTimeout(res.errmsg,3000,function(){
                                var data=res.data;
                                window.location.href=data.redirect_uri;
                            });
                        } else {
                            $("input[name='password']").val('');
                            if(yzm_open==1) {
                                $("input[name='checkcode']").val('');
                                reimg();
                            }
                            $.showErr(res.errmsg);
                        }
                    },
                    error:function(){
                        $.showErr('服务器繁忙，请稍后...');
                    }
                });
            }
        });
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
    function reimg()
    {
        var img = document.getElementById("img");
        img.src = "<?=site_url('admin/common/checkcode')?>?rnd=" + Math.random();
    }
</script>
</body>
</html>
