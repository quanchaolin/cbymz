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
                    <li><a  href="<?=$this->baseurl.'add?msgtype=image'?>">图片消息</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=voice'?>" aria-expanded="false">语音消息</a></li>
                    <li class="active"><a href="javascript:void(0);">视频消息</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=music'?>" >音乐消息</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=news'?>">图文消息（点击跳转到外链）</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=mpnews'?>">图文消息（点击跳转到图文消息页面）</a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="siteTab">
                        <form method="post" action="<?=$this->baseurl?>save" id="form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                            <input type="hidden" name="msgtype" value="video" />
                            <input type="hidden" name="id" value="<?=$value['id']?>">
                            <div class="form-group">
                                <label for="title" class="col-sm-3 control-label">标题</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="title" name="title" value="<?= $value['title'] ?>" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-sm-3 control-label">* 媒体ID</label>
                                <div class="col-sm-5">
                                    <input type="text" name="media_id" id="media_id" value="<?= $value['media_id'] ?>" class="form-control" data-parsley-required="true" />
                                </div>
                                <div class="col-sm-1">
                                    <a class="btn btn-primary btn-select">选择</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-3 control-label">描述</label>
                                <div class="col-sm-6">
                                    <textarea name="description" class="form-control" id="description" rows="3" cols="20"><?=$value['description']?></textarea>
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
<?php $this->load->view('admin/page_common'); ?>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">视频选择</h4>
            </div>
            <div class="modal-body" style="max-height:400px;overflow-y:auto;padding: 0">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <div class="box box-primary" style="border: none;">
                        <div class="box-header with-border">
                            <div class="pull-right">
                                <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                    <input type="text" name="keyword" class="form-control pull-right" placeholder="名称..."  value="" >
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default search"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <div class="table-responsive model-mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>选择</th>
                                        <th>名称</th>
                                        <th>描述</th>
                                    </tr>
                                    </thead>
                                    <tbody id="contentList">
                                    </tbody>
                                </table>
                                <!-- /.table -->
                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer no-padding">
                            <div id="userPage" >

                            </div>
                        </div>
                    </div>
                    <!-- /. box -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary btn-save">保存</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- /.modal -->
<script id="contentListTemplate" type="x-tmpl-mustache">
    {{#contentList}}
        <tr role="row" class="odd" data-id="{{id}}">
            <td><input type="radio" name="image_item" value="{{media_id}}" data-name={{name}} data-description={{description}}></td>
            <td>{{name}}</br>{{media_id}}</td>
            <td>{{description}}</td>
        </tr>
    {{/contentList}}
</script>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<script type="application/javascript">
    $(function () {
        var contentListTemplate=$("#contentListTemplate").html();
        Mustache.parse(contentListTemplate);
        function loadContentList() {
            var keywords=$("input[name='keyword']").val();
            var url = "<?=site_url('admin/material_video/video_lists/')?>" ;
            $.ajax({
                type:'get',
                dataType:"json",
                url : url,
                data:{keywords:keywords},
                success: function (result) {
                    renderUserListAndPage(result, url);
                }
            })
        }
        function renderUserListAndPage(result, url) {
            if (result.errcode==0) {
                if (result.data.total > 0){
                    contentList = result.data.data;
                    var rendered = Mustache.render(contentListTemplate, {
                        contentList: result.data.data
                    });
                    $("#contentList").html(rendered);
                    var pageSize = 10;
                    var pageNo = parseInt($("#userPage .pageNo").val()) || 1;
                    renderPage(url, result.data.total, pageNo, pageSize, result.data.total > 0 ? result.data.data.length : 0, "userPage", renderUserListAndPage);
                } else {
                    $("#contentList").html('');
                }
            } else {
                $.showErr(result.errmsg);
            }
        }
        $(".search").on('click',function(){
            loadContentList();
        });
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
        $(".btn-select").on('click',function(){
            loadContentList();
            $('#modal-default').modal('show');
        });
        $('.btn-save').on('click',function(){
            var media_id=$("input[name='image_item']:checked").val();
            var name=$("input[name='image_item']:checked").attr('data-name');
            var description=$("input[name='image_item']:checked").attr('data-description');
            if(typeof media_id !=undefined)
            {
                $("#media_id").val(media_id);
                if($("input[name='title']").val()=='')
                {
                    $("input[name='title']").val(name);
                }
                if($("#description").val()=='')
                {
                    $("#description").val(description);
                }
            }
            $('#modal-default').modal('hide');
        });
    });
</script>
