<?php $this->load->view('admin/header'); ?>
<link href="<?=base_url('static/plugins/umeditor/themes/default/css/umeditor.css')?>" type="text/css" rel="stylesheet">
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
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">标题<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="title" name="title" value="<?= $value['title'] ?>" class="form-control" data-parsley-required="true" data-parsley-required-message="标题不可为空" />
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="department" class="control-label col-md-3 col-sm-3 col-xs-12">义工</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="volunteer_id" id="volunteer_id" class="form-control select2">
                                    <option value="">请选择</option>
                                    <?php foreach($volunteer as $k=>$val):?>
                                        <option value="<?=$val['id']?>" <?php if($value['volunteer_id']==$val['id'])echo 'selected';?>><?=$val['name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">消息内容</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <script type="text/plain" id="myEditor" style="width:780px;height:240px;"><?=$value['content']?></script>
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
            data.content=getContent();
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

    });
</script>