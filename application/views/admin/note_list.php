<?php $this->load->view('admin/header'); ?>
<!---parsley.css--->
<link href="<?=base_url('vendor/parsleyjs/src/parsley.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <a href="javascript:history.back();">
                <返回&nbsp;&nbsp;
            </a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl?>">笔记</a></li>
            <li class="active">编辑</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <form method="post" action="<?=$this->baseurl?>save" id="form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="config_name">配置名<span class="required">*</span>
                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <input type="text" id="config_name" name="config_name" value="<?= $value['config_name'] ?>" class="form-control" data-parsley-required="true" data-parsley-required-message="配置名不可为空" />
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="value">配置值<span class="required">*</span>
                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <input type="text" id="value" name="value" value="<?= $value['value'] ?>" class="form-control" data-parsley-required="true" data-parsley-required-message="配置值不可为空" />
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">描述
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="description" class="description form-control"><?= $value['description'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-md-9 col-sm-12 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="button" onclick="javascript:history.back();">取消</button>
                        <button class="btn btn-primary" type="reset">重置</button>
                        <button type="submit" class="btn btn-success" id="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
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
<!-- Page script -->
<script>
    $(function () {
        Parsley.on('form:submit', function() {
            var id = $("input[name='id']").val();
            var $form = $("#form");
            var data=serializeForm($form);
            $.post($form.attr('action'), {id:id,value:data}, function(res) {
                if(res.errcode==0){
                    $.showSuccessTimeout(res.errmsg,3000,function(){
                        window.location.href='<?=$this->baseurl?>index';
                    });
                }else{
                    $.showErr(res.errmsg);
                }
            }, 'json');
            return false; // Don't submit form for this demo
        });
    })
</script>