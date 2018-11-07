<?php $this->load->view('admin/header'); ?>
<link type="text/css" rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-fileinput/css/fileinput.min.css')?>" />
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
                    <li><a href="<?=$this->baseurl.'add?msgtype=music'?>" >音乐消息</a></li>
                    <li class="active"><a href="javascript:void(0);">图文消息（点击跳转到外链）</a></li>
                    <li><a href="<?=$this->baseurl.'add?msgtype=mpnews'?>">图文消息（点击跳转到图文消息页面）</a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="siteTab">
                        <form method="post" action="<?=$this->baseurl?>save_news" id="form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                            <input type="hidden" name="msgtype" value="news" />
                            <input type="hidden" name="id" value="<?=$value['id']?>">
                            <?php if(!$value['back_paper_item']):?>
                                <div class="news-list">
                                    <div class="form-group">
                                        <label for="title" class="col-sm-3 control-label">* 标题</label>
                                        <div class="col-sm-6">
                                            <input type="hidden" name="back_paper_item_id" value="">
                                            <input type="text" class="form-control" id="title" name="title" value="" data-parsley-required="true">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-3 control-label">* 封面图片链接</label>
                                        <div class="col-md-6">
                                            <div class="file-loading">
                                                <input class="image_url picurl" data-url="" name="file" type="file" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-3 control-label">* 详情页图片</label>
                                        <div class="col-md-6">
                                            <div class="file-loading">
                                                <input class="image_url thumb" data-url="" name="file" type="file" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="url" class="col-sm-3 control-label">跳转的链接</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="url" id="url" value="" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-3 control-label">消息的描述</label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control description" name="description" id="description" rows="3" cols="20"></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php else:?>
                                <?php foreach($value['back_paper_item'] as $key=>$back_paper_item):?>
                                    <div class="news-list">
                                        <div class="form-group">
                                            <label for="title" class="col-sm-3 control-label">* 标题</label>
                                            <div class="col-sm-6">
                                                <input type="hidden" name="back_paper_item_id" value="<?=$back_paper_item['back_paper_id']?>">
                                                <input type="text" class="form-control" id="title" name="title" value="<?= $back_paper_item['title'] ?>" data-parsley-required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="title" class="col-sm-3 control-label">* 封面图片链接</label>
                                            <div class="col-md-6">
                                                <div class="file-loading">
                                                    <input class="image_url picurl" data-url="<?=$back_paper_item['picurl']?>" name="file" type="file" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="title" class="col-sm-3 control-label">* 详情页图片</label>
                                            <div class="col-md-6">
                                                <div class="file-loading">
                                                    <input class="image_url thumb" data-url="<?=$back_paper_item['thumb']?>" name="file" type="file" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="url" class="col-sm-3 control-label">跳转的链接</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="url" id="url" value="<?= $back_paper_item['url'] ?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="col-sm-3 control-label">消息的描述</label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control description" name="description" id="description" rows="3" cols="20"><?=$back_paper_item['description']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
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
<script type="text/javascript" src="<?=base_url('static/plugins/bootstrap-fileinput/js/fileinput.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/plugins/bootstrap-fileinput/js/locales/zh.js')?>"></script>

<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<script type="application/javascript">
    $(function () {
        Parsley.on('form:submit', function() {
            var id = $("input[name='id']").val();
            var $form = $("#form");
            var list=new Array();
            $(".news-list").each(function(index,val){
                var $news_list=$(".news-list").eq(index)
                    ,back_paper_item_id=$news_list.find("input[name='back_paper_item_id']").val()
                    ,item_title=$news_list.find("input[name='title']").val()
                    ,item_picurl=$news_list.find(".picurl").attr('data-url')
                    ,item_thumb=$news_list.find(".thumb").attr('data-url')
                    ,item_url=$news_list.find("input[name='url']").val()
                    ,item_description=$news_list.find(".description").val();
                var arr={back_paper_item_id:back_paper_item_id,title:item_title,picurl:item_picurl,thumb:item_thumb,url:item_url,description:item_description};
                if(item_title!='')
                {
                    list.push(arr);
                }
                console.log(list);
            });
            $.post($form.attr('action'), {id:id,list:list}, function(res) {
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
        $(".image_url").fileinput({
            uploadUrl: "<?=site_url('admin/file/image_upload/')?>",
            uploadAsync: true,
            showPreview: false,
            language : 'zh',
            allowedFileExtensions: ['jpg', 'png','jpeg'],
            maxFileCount: 1,
            elErrorContainer: '#kv-error-1'
        }).on('filebatchpreupload', function(event, data, id, index) {
            $('#kv-success-1').html('<h4>上传状态</h4><ul></ul>').hide();
        }).on('fileuploaded', function(event, data, id, index) {
            var url=data.response.url;
            $(this).attr('data-url',url);
        });
    });
</script>
