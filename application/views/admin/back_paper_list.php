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
            <li class="active">列表</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">查询条件</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <a href="<?= $this->baseurl . 'add' ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> 新建</a>
                    </div>
                    <div class="col-md-10">
                        <form class="form-horizontal" action="<?=$this->baseurl?>" method="get">
                            <div class="form-inline pull-right">
                                <label class="hidden-sm control-label" style="">消息类型</label>
                                <select name="msgtype" id="msgtype" class="form-control select2 hidden-sm" style="width: 90px;">
                                    <option value="">全部</option>
                                    <?php foreach($this->msgtype as $key=>$val):?>
                                        <option value="<?=$key?>" <?php if($this->msgtype==$key)echo 'selected';?>><?=$val?></option>
                                    <?php endforeach;?>
                                </select>
                                <input type="text" name="keywords" value="<?= $keywords ?>" class="form-control" style="width: 117px;" placeholder="名称...">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.box -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>序号</th>
                                <th>消息标题</th>
                                <th>消息类型</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($list as $key => $value): ?>
                                <tr>
                                    <td width="5%"><?= $key+1 ?></td>
                                    <td width="30%"><?= $value['title'] ?></td>
                                    <td width="15%"><?= $value['msgtype'] ?></td>
                                    <td width="15%"><?= $value['add_time'] ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-default btn-xs btn-preview" data-id="<?=$value['id']?>"><i class="fa fa-eye"></i> 预览 </a>
                                        <span class="label label-sm <?php if($value['status']==1){echo 'label-success';}else{echo 'label-warning';}?> update-status" data-id="<?=$value['id']?>" data-status="<?=$value['status']?>"><?=config_item('status')[$value['status']]?></span>
                                        <a href="<?= $this->baseurl . 'edit?&id=' . $value['id'] ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> 编辑 </a>
                                        <a href="javascript:void(0);" data-url="<?= $this->baseurl . 'delete?id=' . $value['id'] ?>" data-title="<?=$value['title']?>" class="btn btn-danger btn-xs btn-del"><i class="fa fa-trash-o"></i> 删除 </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <span class="col-md-3">共 <?= $count ?> 条</span>
                        <?= $pages ?>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">预览</h4>
            </div>
            <div class="modal-body" style="max-height:400px;overflow-y:auto;padding: 0">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <div class="box box-primary" style="border: none;">
                        <div class="box-header with-border">
                            <div class="pull-right">
                                <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                    <input type="text" name="keyword" class="form-control pull-right" placeholder="用户昵称..."  value="" >
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default submit"><i class="fa fa-search"></i></button>
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
                                        <th><button type="button" class="btn btn-default btn-sm modal-checkbox-toggle"><i class="fa fa-square-o"></i></button></th>
                                        <th>用户昵称</th>
                                        <th>openid</th>
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
                <input type="hidden" name="id" value="">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary btn-save">提交</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $this->load->view('admin/footer'); ?>
<?php $this->load->view('admin/page_common'); ?>
<script id="contentListTemplate" type="x-tmpl-mustache">
{{#contentList}}
<tr role="row" class="user-name odd" data-id="{{openid}}"><!--even -->
    <td><input name="user" value="{{openid}}" type="checkbox"></td>
    <td>{{nickname}}</a></td>
    <td>{{openid}}</a></td>
</tr>
{{/contentList}}
</script>
<script>
    $(function(){
        var contentListTemplate = $('#contentListTemplate').html();
        Mustache.parse(contentListTemplate);
        $(".btn-preview").on('click',function(){
            var id=$(this).attr('data-id');
            $("input[name='id']").val(id);
            loadUserList();
            $('#modal-default').modal('show')
        });
        $(".submit").on('click',function(){
            loadUserList();
        });
        function loadUserList() {
            var id=$("#projectId").val()
                ,keywords=$("input[name='keyword']").val()
                ,url='<?=site_url('admin/user/lists/')?>';
            if(id==0)return false;
            var pageSize = 10;
            var pageNo = $("#userSelPage .pageNo").val() || 1;
            $.ajax({
                type:'get',
                dataType:"json",
                url : url,
                data: {
                    keywords:keywords,
                    pageSize: pageSize,
                    pageNo: pageNo
                },
                success: function (result) {
                    renderUserListAndPage(result, url);
                }
            })
        }
        function renderUserListAndPage(result, url) {
            if (result.errcode==0) {
                if (result.data.total > 0){
                    var rendered = Mustache.render(contentListTemplate, {
                        contentList: result.data.data
                    });
                    $("#contentList").html(rendered);
                    $('#contentList input[type="checkbox"]').iCheck({
                        checkboxClass: 'icheckbox_flat-blue'
                    });
                } else {
                    $("#contentList").html('');
                }
                var pageSize = 10;
                var pageNo = parseInt($("#userPage .pageNo").val()) || 1;
                renderPage(url, result.data.total, pageNo, pageSize, result.data.total > 0 ? result.data.data.length : 0, "userPage", renderUserListAndPage);
            } else {
                $.showErr(result.errmsg);
            }
        }
        $(".modal-checkbox-toggle").click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                $(".model-mailbox-messages input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                $(".model-mailbox-messages input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });
        $(".btn-del").on('click',function(){
            var url=$(this).attr('data-url')
                ,title=$(this).attr('data-title');
            $.showConfirm('确定要删除【'+title+'】吗？',function(){
                window.location.href=url;
            });
        });
        $(".btn-save").on('click',function(){
            var chk_value =[];
            $('input[name="user"]:checked').each(function(){
                chk_value.push($(this).val());
            });
            var url='<?=$this->baseurl.'preview'?>';
            var id=$("input[name='id']").val();
            $.post(url,{id:id,value:chk_value},function(res){
                if(res.errcode==0){
                    $.showSuccessTimeout(res.errmsg,3000,function(){});
                    $('#modal-default').modal('hide');
                }else{
                    $.showErr(res.errmsg);
                }
            }, 'json');
        });
        // 点击更改状态
        $(".update-status").click(function () {
            var id=$(this).attr('data-id')
                ,status = $(this).attr("data-status")
                ,new_status;
            if (status == 1) {
                new_status=2;
                $(this).text("锁定");
                $(this).attr('data-status','2');
                $(this).removeClass('label-success').addClass('label-warning');
            } else {
                new_status=1;
                $(this).text("正常");
                $(this).attr('data-status','1');
                $(this).removeClass('label-warning').addClass('label-success');
            }
            $.get("<?=$this->baseurl . 'update_status'?>", {id: id, status:new_status }, function (data) {
                console.log(data);
            });
        });
    });
</script>