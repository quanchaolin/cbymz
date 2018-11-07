<?php $this->load->view('admin/header'); ?>
<!-- some CSS styling changes and overrides -->
<style>
    .kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar {
        display: inline-block;
    }
    .kv-avatar .file-input {
        display: table-cell;
        width: 213px;
    }
    .kv-reqd {
        color: red;
        font-family: monospace;
        font-weight: normal;
    }
</style>
<link href="<?=base_url('static/plugins/umeditor/themes/default/css/umeditor.css')?>" type="text/css" rel="stylesheet">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')?>">
<link type="text/css" rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-fileinput/css/fileinput.min.css')?>" />
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
            <li><a href="<?=$this->baseurl.'index'?>">商品管理</a></li>
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
                        <input  name="main_img" type="hidden" value="<?=$value['main_img']?>">
                        <input  name="detail_img" type="hidden" value="<?=$value['detail_img']?>">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">商品名称<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="name" name="name" value="<?= $value['name'] ?>" class="form-control" data-parsley-required="true" data-parsley-required-message="商品名称不可为空" />
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="category" class="control-label col-md-3 col-sm-3 col-xs-12">分类</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?=$categorytree?>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="department" class="control-label col-md-3 col-sm-3 col-xs-12">回向文</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="back_paper_id" id="back_paper_id" class="form-control select2">
                                    <option value="">请选择</option>
                                    <?php foreach($back_paper as $k=>$val):?>
                                        <option value="<?=$val['id']?>" <?php if($value['back_paper_id']==$val['id'])echo 'selected';?>><?=$val['title']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">商品价格</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <input id="price" name="price" class="form-control" type="text" value="<?= $value['price'] ?>" data-parsley-required="true">
                            </div>
                            <label class="control-label col-md-2 col-sm-12 col-xs-12">最低价格</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <input id="min_price" name="min_price" class="form-control" type="number" value="<?= $value['min_price'] ?>">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">链接地址</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <input id="product_url" name="product_url" class="form-control" type="text" value="<?= $value['product_url'] ?>">
                            </div>
                            <label class="control-label col-md-2 col-sm-12 col-xs-12">排序</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <input id="order" name="order" class="form-control" type="number" value="<?= $value['order'] ?>">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">开始时间</label>
                            <div class="col-md-2 col-sm-12 col-xs-12 date">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="start_time" name="start_time" class="form-control pull-right form_datetime" type="text" value="<?= $value['start_time'] ?>" />
                                </div>
                            </div>
                            <label class="control-label col-md-2 col-sm-12 col-xs-12">结束时间</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="end_time" name="end_time" class="form-control pull-right form_datetime" type="text" value="<?= $value['end_time'] ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12" for="town_check">发送通知</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <div class="col-md-6">
                                    <input type="radio" name="send_msg" value="1" id="send_msg1" class="flat-red" <?php if($value['send_msg']==1)echo 'checked';?>>
                                    <label for="send_msg1">是</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" name="send_msg" value="0" id="send_msg2" class="flat-red" <?php if($value['send_msg']==0)echo 'checked';?>>
                                    <label for="send_msg2">否</label>
                                </div>
                            </div>
                            <label class="control-label col-md-2 col-sm-12 col-xs-12">状态</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <div class="col-md-6">
                                    <input type="radio" name="status" value="1" id="status1" class="flat-red" <?php if($value['status']==1)echo 'checked';?>>
                                    <label for="status1">开启</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" name="status" value="0" id="status2" class="flat-red" <?php if($value['status']==0)echo 'checked';?>>
                                    <label for="status2">关闭</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">支付标题</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <input id="pay_title" name="pay_title" class="form-control" type="text" value="<?= $value['pay_title'] ?>">
                            </div>
                            <label class="control-label col-md-2 col-sm-12 col-xs-12">视图模板</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <input id="tpl" name="tpl" class="form-control" type="text" value="<?= $value['tpl'] ?>">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12">主图</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <div class="kv-avatar">
                                    <div class="file-loading">
                                        <input id="main_img" name="file" type="file" required>
                                    </div>
                                </div>
                            </div>
                            <label class="control-label col-md-2 col-sm-12 col-xs-12">详情图</label>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <div class="kv-avatar">
                                    <div class="file-loading">
                                        <input id="detail_img" name="file" type="file" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">备注
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="remark" class="remark form-control"><?= $value['remark'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">商品详情</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <script type="text/plain" id="myEditor" style="width:780px;height:240px;"><?=$value['detail']?></script>
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
<script type="text/javascript" src="<?=base_url('static/plugins/umeditor/third-party/template.min.js')?>"></script>
<script type="text/javascript" charset="utf-8" src="<?=base_url('static/plugins/umeditor/umeditor.config.js')?>"></script>
<script type="text/javascript" charset="utf-8" src="<?=base_url('static/plugins/umeditor/umeditor.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/plugins/umeditor/lang/zh-cn/zh-cn.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/plugins/bootstrap-fileinput/js/fileinput.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/plugins/bootstrap-fileinput/js/locales/zh.js')?>"></script>
<!-- bootstrap datepicker -->
<script src="<?=base_url('static/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')?>"></script>
<script src="<?=base_url('static/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')?>"></script>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<!-- Page script -->
<script type="text/javascript">
    //实例化编辑器
    var um = UM.getEditor('myEditor');

    //按钮的操作
    function insertHtml(value) {
        um.execCommand('insertHtml', value)
    }
    function getContent() {
        return UM.getEditor('myEditor').getContent();
    }

    function getText() {
        //当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
        var range = UM.getEditor('myEditor').selection.getRange();
        range.select();
        var txt = UM.getEditor('myEditor').selection.getText();
        alert(txt)
    }
    function setContent(value,isAppendTo) {
        UM.getEditor('myEditor').setContent(value, isAppendTo);
    }
    function hasContent() {
        return UM.getEditor('myEditor').hasContents();
    }
</script>
<script>
    $(function () {
        Parsley.on('form:submit', function() {
            var id = $("input[name='id']").val();
            var $form = $("#form");
            var data=serializeForm($form);
            data.detail=getContent();
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
        $('.form_datetime').datetimepicker({
            autoclose: true,
            todayHighlight: true,
            language:"zh-CN", //语言设置
            format: 'yyyy-mm-dd hh:ii:ss'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });
    });
</script>
<!-- the fileinput plugin initialization -->
<script>
    $("#main_img").fileinput({
        uploadUrl:"<?=site_url('admin/file/image_upload/')?>",
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',
        language : 'zh',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: '取消或重置更改',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="<?=base_url($value['main_img'])?>" alt="主图"  width="213" height="160"><h6 class="text-muted">点击选择</h6>',
        layoutTemplates: {main2: '{preview} {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    }).on("fileuploaded", function(event, data) {
        if(data.response.state=='SUCCESS')
        {
            $("input[name='main_img']").val(data.response.url);
        }
    });
    $("#detail_img").fileinput({
        uploadUrl:"<?=site_url('admin/file/image_upload/')?>",
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',
        language : 'zh',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: '取消或重置更改',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="<?=base_url($value['detail_img'])?>" alt="详情图"  width="213" height="160"><h6 class="text-muted">点击选择</h6>',
        layoutTemplates: {main2: '{preview} {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    }).on("fileuploaded", function(event, data) {
        if(data.response.state=='SUCCESS')
        {
            $("input[name='detail_img']").val(data.response.url);
        }
    });
</script>