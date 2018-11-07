<?php $this->load->view('admin/header'); ?>
<!---parsley.css--->
<link href="<?=base_url('vendor/parsleyjs/src/parsley.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl.'index'?>">个人中心</a></li>
            <li class="active">密码修改</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php $this->load->view('admin/profile_left'); ?>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <form class="form-horizontal" method="post" action="#" id="pwdForm" data-parsley-validate>
                                <div class="form-group">
                                    <label for="userOldPassword" class="col-sm-2 control-label">原密码</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="userOldPassword" name="old_password" value="" data-parsley-required="true" data-parsley-required-message="原密码不可为空" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputNewPassword" class="col-sm-2 control-label">新密码</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="inputNewPassword" name="new_password" value="" data-parsley-required="true" data-parsley-required-message="新密码不可为空" data-parsley-minlength="6" data-parsley-minlength-message="密码位数不可少于6位">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputConfirmPassword" class="col-sm-2 control-label">确认密码</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="inputConfirmPassword" name="confirm_password" value="" data-parsley-required="true" data-parsley-trigger="focusout" data-parsley-required-message="确认密码不可为空" data-parsley-equalto="#inputNewPassword" data-parsley-equalto-message="两次密码输入不一致" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">提交</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->load->view('admin/footer'); ?>
<!-- Parsley -->
<script src="<?=base_url('vendor/parsleyjs/dist/parsley.min.js')?>"></script>
<script src="<?=base_url('vendor/parsleyjs/dist/i18n/zh_cn.js')?>"></script>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<script>
    $(function(){
        $('#pwdForm').parsley().on('form:validated', function() {
            var ok = $('.parsley-error').length === 0;
            if(ok)
            {
                var $form = $("#pwdForm")
                    ,data=serializeForm($form);
                $.ajax({
                    type: 'POST',
                    dataType:"json",
                    url:  "<?=$this->baseurl.'pwd_save'?>",
                    data: {value:data},
                    success: function(res) {
                        if (res.errcode==0) {
                            $.showSuccessTimeout(res.errmsg,3000,function(){
                                window.location.reload();
                            });
                        } else {
                            $.showErr(res.errmsg);
                        }
                    }
                })
            }
        });
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
</script>