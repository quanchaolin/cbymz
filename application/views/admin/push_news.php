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
                            <div id="resultHtml"></div>
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
            var list=new Array();
            $(".news-list").each(function(index,val){
                var $news_list=$(".news-list").eq(index)
                    ,back_paper_item_id=$news_list.find("input[name='back_paper_item_id']").val()
                    ,item_title=$news_list.find("input[name='title']").val()
                    ,item_picurl=$news_list.find("input[name='picurl']").val()
                    ,item_url=$news_list.find("input[name='url']").val()
                    ,item_description=$news_list.find(".description").val();
                var arr={back_paper_item_id:back_paper_item_id,title:item_title,picurl:item_picurl,url:item_url,description:item_description};
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
    });
</script>
<script id="listTemplate" type="x-tmpl-mustache">
{{#MustacheList}}
    <div class="news-list">
        <div class="col-sm-9">
            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">* 标题</label>
                <div class="col-sm-9">
                    <input type="hidden" name="back_paper_item_id" value="{{push_id}}">
                    <input type="text" class="form-control" id="title" name="title" value="{{title}}" data-parsley-required="true">
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">* 封面图片链接</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="picurl" value="{{picurl}}" data-parsley-required="true">
                </div>
            </div>
            <div class="form-group">
                <label for="url" class="col-sm-3 control-label">跳转的链接</label>
                <div class="col-sm-9">
                    <input type="text" name="url" id="url" value="{{url}}" class="form-control" data-parsley-required="true" />
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-3 control-label">消息的描述</label>
                <div class="col-sm-9">
                    <textarea class="form-control description" name="description" id="description" data-parsley-required="true" rows="3" cols="20">{{description}}</textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <span><i class="fa fa-plus-circle btn-add"></i></span>
            &nbsp;&nbsp;&nbsp;
            <span><i class="fa fa-minus-circle btn-del"></i></span>
        </div>
    </div>
 {{/MustacheList}}
</script>
<script>
    $(function () {
        var listTemplate = $("#listTemplate").html();
        Mustache.parse(listTemplate);
        var push_item=<?=$push_item?>;
        var render;
        if(push_item.length==0){
                render = Mustache.render(listTemplate,{
                MustacheList:[{id:0,title:'',picurl:'',url:'',description:''}]
            });
        }else {
            render = Mustache.render(listTemplate,{
                MustacheList:push_item
            });
        }
        $("#resultHtml").html(render);

        $(document).on('click','.btn-add',function(){
            render = Mustache.render(listTemplate,{
                MustacheList:[{id:0,title:'',picurl:'',url:'',description:''}]
            });
            $("#resultHtml").append(render);
        });

        $(document).on('click','.btn-del',function(){
            var index = $('.btn-del').index($(this));
            $('.news-list').eq(index).remove();
            if($('.news-list').length==0){
                render = Mustache.render(listTemplate,{
                    MustacheList:[{id:0,title:'',picurl:'',url:'',description:''}]
                });
                $("#resultHtml").append(render);
            }
        });
    })
</script>
