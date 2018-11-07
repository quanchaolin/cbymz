<?php $this->load->view('admin/header'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl?>">系统配置</a></li>
            <li class="active">列表</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box">
            <div class="nav-tabs-custom" id="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#siteTab" data-toggle="tab" aria-expanded="false">网站信息</a></li>
                    <li class=""><a href="#mailTab" data-toggle="tab" aria-expanded="true">邮件选项</a></li>
                    <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">系统设置</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="siteTab">
                        <form class="form-horizontal" id="siteForm" method="post" action="#" data-parsley-validate>
                            <div class="form-group">
                                <label for="inputSiteName" class="col-sm-2 control-label">站点名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="site_name" id="inputSiteName" placeholder="" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSiteTitle" class="col-sm-2 control-label">站点标题</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSiteTitle" name="site_title" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSiteKeywords" class="col-sm-2 control-label">站点关键词</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSiteKeywords" name="site_keywords" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSiteDescription" class="col-sm-2 control-label">站点描述</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputSiteDescription" name="site_description" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSiteCopyright" class="col-sm-2 control-label">版权信息</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSiteCopyright" name="site_copyright" placeholder="" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="mailTab">
                        <form class="form-horizontal" id="mailForm" method="post" action="#" data-parsley-validate>
                            <div class="form-group">
                                <label for="inputEmailHost" class="col-sm-2 control-label">邮件服务器</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="email_host" id="inputEmailHost" placeholder="" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmailUsername" class="col-sm-2 control-label">SMTP验证的用户名称</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputEmailUsername" name="email_username" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmailPassword" class="col-sm-2 control-label">SMTP验证的秘密</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputEmailPassword" name="email_password" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-info">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                        <form class="form-horizontal" id="setForm" method="post" action="#" data-parsley-validate>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">验证码</label>
                                <div class="col-sm-10">
                                    <div class="col-md-2">
                                        <input type="radio" name="yzm_open" value="1" id="yzm_open1" class="flat-red" <?php if($value['yzm_open']==1)echo 'checked';?>>
                                        <label for="yzm_open1">开启</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" name="yzm_open" value="0" id="yzm_open2" class="flat-red" <?php if($value['yzm_open']==0)echo 'checked';?>>
                                        <label for="yzm_open2">关闭</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>

        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('admin/footer'); ?>

<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<script>
    $(function(){
        loadSiteInfo();
        $("#tabbable a[data-toggle='tab']").on("shown.bs.tab", function(e) {
            if (e.target.getAttribute("href") == '#siteTab') {

            } else if(e.target.getAttribute("href") == '#mailTab') {
                loadMailInfo();
            }
        });
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            radioClass   : 'iradio_flat-green'
        });
        $('#siteForm').parsley().on('form:validated', function() {
            var ok = $('#siteForm .parsley-error').length === 0;
            if(ok)
            {
                var $form = $("#siteForm");
                save($form);
            }
        });
        $('#mailForm').parsley().on('form:validated', function() {
            var ok = $('#mailForm .parsley-error').length === 0;
            if(ok)
            {
                var $form = $("#mailForm");
                save($form);
            }
        });
        $('#setForm').parsley().on('form:validated', function() {
            var ok = $('#mailForm .parsley-error').length === 0;
            if(ok)
            {
                var $form = $("#setForm");
                save($form);
            }
        });
        function save(form)
        {
            var data=serializeForm(form);
            $.ajax({
                type: 'POST',
                dataType:"json",
                url:  "<?=$this->baseurl.'save'?>",
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
        function loadSiteInfo()
        {
            $.ajax({
                type: 'POST',
                dataType:"json",
                url:  "<?=$this->baseurl.'site_info'?>",
                success: function(res) {
                    var data=res.data;
                    if (res.errcode==0) {
                        $("#inputSiteName").val(data.site_name);
                        $("#inputSiteTitle").val(data.site_title);
                        $("#inputSiteKeywords").val(data.site_keywords);
                        $("#inputSiteDescription").val(data.site_description);
                        $("#inputSiteCopyright").val(data.site_copyright);
                    } else {
                        $.showErr(res.errmsg);
                    }
                }
            })
        }
        function loadMailInfo()
        {
            $.ajax({
                type: 'POST',
                dataType:"json",
                url:  "<?=$this->baseurl.'mail_info'?>",
                success: function(res) {
                    var data=res.data;
                    if (res.errcode==0) {
                        $("#inputEmailHost").val(data.email_host);
                        $("#inputEmailUsername").val(data.email_username);
                        $("#inputEmailPassword").val(data.email_password);
                    } else {
                        $.showErr(res.errmsg);
                    }
                }
            })
        }
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
</script>