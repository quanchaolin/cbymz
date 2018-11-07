<?php $this->load->view('admin/header'); ?>
<link href="<?=base_url('vendor/cropperjs/dist/cropper.min.css')?>" rel="stylesheet">
<link href="<?=base_url('static/css/crop-avatar_css_main.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="crop-avatar">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl.'index'?>">个人中心</a></li>
            <li class="active">资料</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php $this->load->view('admin/profile_left'); ?>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom" id="tabbable">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">设置</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings" >
                            <form class="form-horizontal" method="post" action="#" id="userForm" data-parsley-validate>
                                <div class="form-group">
                                    <label for="userName" class="col-sm-2 control-label">姓名</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" name="true_name" value="<?=$value['true_name']?>" data-parsley-required="true" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">用户名</label>

                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control" id="inputUsername" value="<?=$value['username']?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputTelephone" class="col-sm-2 control-label">电话号码</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputTelephone" name="telephone" value="<?=$value['telephone']?>"data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputMail" class="col-sm-2 control-label">邮箱</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputMail" name="mail" value="<?=$value['mail']?>" data-parsley-required="true" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPositionalTitles" class="col-sm-2 control-label">职称</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPositionalTitles" name="positional_titles" value="<?=$value['positional_titles']?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputRemark" class="col-sm-2 control-label">备注</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputRemark" name="remark" placeholder=""><?=$value['remark']?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">提交</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('admin/footer'); ?>
<script src="<?=base_url('static/plugins/parsleyjs/dist/i18n/zh_cn.js')?>"></script>
<script src="<?=base_url('static/plugins/cropperjs/dist/cropper.min.js')?>"></script>
<script src="<?=base_url('static/js/avatar_js_main.js')?>"></script>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<script>
    $(function(){
        $("#tabbable a[data-toggle='tab']").on("shown.bs.tab", function(e) {
            if (e.target.getAttribute("href") == '#roleAclTab') {

            } else {

            }
        });
        $('#userForm').parsley().on('form:validated', function() {
            var ok = $('.parsley-error').length === 0;
            if(ok)
            {
                var $form = $("#userForm")
                    ,data=serializeForm($form);
                var skills=$(".skills").val();
                $.ajax({
                    type: 'POST',
                    dataType:"json",
                    url:  "<?=$this->baseurl.'save'?>",
                    data: {value:data,skills:skills},
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