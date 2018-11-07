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
            <li><a href="<?=$this->baseurl?>">回向文</a></li>
            <li class="active">编辑</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box">
            <div class="nav-tabs-custom" id="tabbable">
                <ul class="nav nav-tabs">
                    <li><a href="<?=$this->baseurl.'add?msgtype=text'?>">文本消息</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=voice'?>" aria-expanded="false">图片消息</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=voice'?>" aria-expanded="false">语音消息</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=video'?>">视频消息</a></li>
                    <li class="active"><a href="javascript:void(0);" >音乐消息</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=news'?>">图文消息（点击跳转到外链）</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=mpnews'?>">图文消息（点击跳转到图文消息页面）</a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="siteTab">
                        <form method="post" action="<?=$this->baseurl?>save" id="form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                            <input type="hidden" name="msgtype" value="music" />
                            <input type="hidden" name="id" value="<?=$value['id']?>">
                            <div class="form-group">
                                <label for="title" class="col-sm-3 control-label">* 标题</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="title" name="title" value="<?= $value['title'] ?>" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="musicurl" class="col-sm-3 control-label">* 音乐链接</label>
                                <div class="col-sm-6">
                                    <input type="text" name="musicurl" id="musicurl" value="<?= $value['musicurl'] ?>" class="form-control" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hqmusicurl" class="col-sm-3 control-label">* 高品质音乐链接</label>
                                <div class="col-sm-6">
                                    <input type="text" name="hqmusicurl" id="hqmusicurl" value="<?= $value['hqmusicurl'] ?>" class="form-control" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-3 control-label">* 音乐消息的描述</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="description" id="description" rows="3" cols="20"><?=$value['description']?></textarea>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-9 col-sm-12 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button" onclick="javascript:history.back();">取消</button>
                                    <button class="btn btn-primary" type="reset">重置</button>
                                    <button type="submit" class="btn btn-success" id="submit">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
<script type="application/javascript">
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
    });
</script>
