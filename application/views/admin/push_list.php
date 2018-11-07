<?php $this->load->view('admin/header'); ?>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')?>">
<style type="text/css">
    .loading{
        display: none;
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
        z-index: 1100;
        background: #808080;
        opacity: 0.5;
    }
    .loading img{
        position: fixed;
        top: 50%;
        left: 50%;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl?>">消息推送</a></li>
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
                                        <option value="<?=$key?>" <?php if($msgtype==$key)echo 'selected';?>><?=$val?></option>
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
                                        <a href="javascript:void(0);" class="btn btn-warning btn-xs btn-send" data-id="<?=$value['id']?>" data-title="<?=$value['title']?>"><i class="fa fa-send"></i> 发送 </a>
                                        <a href="javascript:void(0);" class="btn btn-warning btn-xs btn-task" data-id="<?=$value['id']?>" ><i class="fa fa-clock"></i> 定时发送 </a>
                                        <a href="<?=site_url('admin/push_record/index?push_id='.$value['id'])?>" class="btn btn-success btn-xs"><i class="fa fa-list"></i> 发送记录 </a>
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
<div class="modal fade" id="dialog-task">
    <div class="modal-dialog">
        <form method="post" action="#" id="roleForm" data-parsley-validate>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">定时任务</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="taskResult">
                        <table class="table table-hover table-striped" role="grid">
                            <tr>
                                <input type="hidden" name="push_id" value="" id="push_id"/>
                                <td><label for="execute_time">执行时间</label></td>
                                <td><input type="text" name="execute_time" id="execute_time" value="" class="form-control form_datetime" data-parsley-required="true"></td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" id="task-submit" >保存</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="loading">
    <img src="<?=base_url('static/images/loading.gif')?>">
</div>
<?php $this->load->view('admin/footer'); ?>
<?php $this->load->view('admin/page_common'); ?>
<!-- bootstrap datepicker -->
<script src="<?=base_url('static/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')?>"></script>
<script src="<?=base_url('static/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')?>"></script>
<script id="contentListTemplate" type="x-tmpl-mustache">
{{#contentList}}
<tr role="row" class="user-name odd" data-id="{{openid}}"><!--even -->
    <td><input name="user" value="{{openid}}" type="checkbox"></td>
    <td>{{nickname}}</a></td>
    <td>{{openid}}</a></td>
</tr>
{{/contentList}}
</script>
<script id="taskTemplate" type="x-tmpl-mustache">
{{#taskList}}
    <table class="table table-hover table-striped" role="grid">
        <tr>
            <td><label for="execute_type">执行方式</label></td>
            <td>
                <select class="form-control" id="execute_type" name="execute_type" data-placeholder="执行方式" style="width: 150px;">
                    <option value="1">一次</option>
                    <option value="2">每天</option>
                    <option value="3">每周</option>
                    <option value="4">每月</option>
                </select>
                <input type="hidden" name="push_id" value="{{push_id}}" id="push_id"/>
            </td>
        </tr>
        <tr>
            <td><label for="execute_time">执行时间</label></td>
            <td>{{#showTime}}{{/showTime}}</td>
        </tr>
        <tr>
            <td><label for="status">状态</label></td>
            <td>
                <select class="form-control" id="status" name="status" data-placeholder="状态" style="width: 150px;">
                    <option value="1">可用</option>
                    <option value="0">冻结</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="roleRemark">备注</label></td>
            <td><textarea name="description"  class="form-control" rows="3" cols="25">{{description}}</textarea></td>
        </tr>
    </table>
 {{/taskList}}
</script>
<script>
    $(function(){
        var contentListTemplate = $('#contentListTemplate').html();
        Mustache.parse(contentListTemplate);
        var taskTemplate = $("#taskTemplate").html();
        Mustache.parse(taskTemplate);
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
        $('.btn-send').on('click', function(){
            var  id=$(this).attr('data-id')
                ,title=$(this).attr('data-title')
                ,url="<?=$this->baseurl?>send";
            $.showConfirm('您确定要发送【'+title+'】吗？',function(){
                $.ajax({
                    type: "POST",
                    url: url ,
                    data: {id:id},
                    cache:false,
                    dataType:"json",
                    beforeSend:function(){
                        $('.loading').css('display','block');
                    },
                    complete:function(){
                        $('.loading').css('display','none');
                    },
                    success: function(res){
                        if(res.errcode==0){
                            $.showSuccessTimeout(res.errmsg,2000,function(){});
                        }else{
                            $.showErr(res.errmsg);
                            return false ;
                        }
                    },
                    error:function(){
                        $.showErr('服务器繁忙,请稍后...');
                    }
                });
            })
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
        //定时任务
        $('.btn-task').click(function () {
            var id = $(this).attr('data-id');
            $("#push_id").val(id);
            $('#dialog-task').modal('show');
            var url='<?=$this->baseurl.'timed_task'?>';
            $.get(url,{id:id},function (res) {
                var data=[{push_id:'',title:'',execute_type:'1',execute_time:'',status:1,description:''}];
                if(res.errcode==0){
                    $("#execute_time").val(res.data.data['execute_time']);
                }
                /*var render=Mustache.render(taskTemplate,{
                    taskList:data,
                    "showTime":function(){
                        var type = this.execute_type;
                        return function(){
                            switch (type)  {
                                case 1:
                                    return '<input type="text" name="true_name" id="trueName" value="'+this.execute_time+'" class="form-control form_datetime" data-parsley-required="true" />';
                                    break;
                                case 2:
                                    return '';
                                    break;
                                case 3:
                                    return '';
                                    break;
                                case 4:
                                    return '';
                                    break;
                            }
                        }
                    }
                });
                $("#taskResult").html(render);*/
            },'json')
        });
        //定时任务保存
        $("#task-submit").click(function (e) {
            e.preventDefault();
            var push_id = $("#push_id").val();
            var execute_time = $("#execute_time").val();
            var url = '<?=$this->baseurl.'task_save'?>';
            $.post(url,{push_id:push_id,execute_time:execute_time},function (res) {
                if(res.errcode==0)
                {
                    $.showSuccessTimeout(res.errmsg,2000,function(){});
                }else {
                    $.showErr(res.errmsg);
                    return false ;
                }
            },'json')
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
        $('.form_datetime').datetimepicker({
            autoclose: true,
            todayHighlight: true,
            language:"zh-CN", //语言设置
            format: 'yyyy-mm-dd hh:ii'
        });
    });
</script>