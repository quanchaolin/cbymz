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
            <li><a href="<?=$this->baseurl?>">消息管理</a></li>
            <li class="active">列表</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box" >
            <div class="nav-tabs-custom" id="tabbable">
                <ul class="nav nav-tabs">
                    <li class="<?php if($this->type!='read' AND $this->type!='all'){echo 'active';}?>"><a href="<?=$this->baseurl.'index?type=unread'?>" aria-expanded="false">未读消息</a></li>
                    <li class="<?php if($this->type=='read'){echo 'active';}?>"><a href="<?=$this->baseurl.'index?type=read'?>" aria-expanded="true">已读消息</a></li>
                    <li class="<?php if($this->type=='all'){echo 'active';}?>"><a href="<?=$this->baseurl.'index?type=all'?>" aria-expanded="false">全部消息</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="siteTab">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="mailbox-controls">
                                        <!-- Check all button -->
                                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm batch-del"><i class="fa fa-trash-o"></i>选中批量删除</button>
                                        <?php if($this->type!='read' AND $this->type!='all'){?>
                                            <button type="button" class="btn btn-default btn-sm batch-read"><i class="fa fa-eye"></i>选中批量已读</button>
                                        <?php }?>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody class="mailbox-messages">
                                            <tr>
                                                <th width="5%">选择</th>
                                                <th>序号</th>
                                                <th>义工姓名</th>
                                                <th>消息标题</th>
                                                <th>邮件发送状态</th>
                                                <th>添加/发送时间</th>
                                                <th>操作</th>
                                            </tr>
                                            <?php foreach ($list as $key => $value): ?>
                                                <tr>
                                                    <td><input type="checkbox" name="item_select" value="<?=$value['id']?>"></td>
                                                    <td><?= $key+1 ?></td>
                                                    <td><?= $value['volunteer_name'] ?></td>
                                                    <td><a href="<?=$this->baseurl.'detail?type='.$this->type.'&id='.$value['id']?>"><?= $value['title'] ?></a></td>
                                                    <td><?= $value['send_email_str'] ?></td>
                                                    <td><?= $value['add_time'] ?><br/><?=$value['update_time']?></td>
                                                    <td>
                                                        <a href="javascript:void(0);" data-id="<?=$value['id']?>" class="btn btn-success btn-xs btn-send_weixin"><i class="fa fa-wechat"></i> 微信发送 </a>
                                                        <a href="javascript:void(0);" data-id="<?=$value['id']?>" class="btn btn-info btn-xs btn-send_email"><i class="fa fa-mail-reply"></i> 邮箱发送 </a>
                                                        <a href="<?= $this->baseurl . 'edit?&id=' . $value['id'] ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> 编辑 </a>
                                                        <a href="javascript:void(0);" data-url="<?= $this->baseurl . 'delete?id=' . $value['id'] ?>" class="btn btn-danger btn-xs btn-del"><i class="fa fa-trash-o"></i> 删除 </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer clearfix">
                                        <span class="col-md-6">共 <?= $count ?> 条</span>
                                        <?= $pages ?>
                                    </div>
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('admin/footer'); ?>
<script>
    $(function(){
        $(".btn-del").on('click',function(){
            var url=$(this).attr('data-url');
            $.showConfirm('确定要删除吗？',function(){
                window.location.href=url;
            });
        });
        $('.btn-send_email').on('click', function(){
            var  id=$(this).attr('data-id')
                ,url="<?=$this->baseurl?>send_email";
            var data_ = {
                id:id
            };
            $.ajax({
                type: "POST",
                url: url ,
                data: data_,
                cache:false,
                dataType:"json",
                success: function(res){
                    if(res.errcode==0){
                        $.showSuccessTimeout(res.errmsg,1500,function(){
                            window.location.reload();
                        });
                    }else{
                        $.showErr(res.errmsg);
                    }
                },
                error:function(){
                    $.showErr('服务器繁忙,请稍后...');
                }
            });
        });
        $('.btn-send_weixin').on('click', function(){
            var  id=$(this).attr('data-id')
                ,url="<?=$this->baseurl?>send_weixin";
            var data_ = {
                id:id
            };
            $.ajax({
                type: "POST",
                url: url ,
                data: data_,
                cache:false,
                dataType:"json",
                success: function(res){
                    if(res.errcode==0){
                        $.showSuccessTimeout(res.errmsg,1500,function(){
                            window.location.reload();
                        });
                    }else{
                        $.showErr(res.errmsg);
                    }
                },
                error:function(){
                    $.showErr('服务器繁忙,请稍后...');
                }
            });
        });
        $(".checkbox-toggle").click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                //Check all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });
        $(".batch-del").on('click',function(){
            var list=new Array();
            $(".mailbox-messages input[type='checkbox']").each(function(index,obj){
                var id=$(this).val();
                if($(this).is(':checked')){
                    list.push(id);
                }
            });
            if(list.length<=0) {
                return false;
            }
            else
            {
                $.showConfirm('您确定要删除选中的消息吗？',function(){
                    $.ajax({
                        type: "POST",
                        url: "<?=$this->baseurl.'batch_delete'?>" ,
                        data: {list:list},
                        cache:false,
                        dataType:"json",
                        success: function(res){
                            if(res.errcode==0){
                                window.location.reload();
                            }else{
                                $.showErr(res.errmsg);
                                return false ;
                            }
                        },
                        error:function(){
                            $.showErr('服务器繁忙,请稍后...');
                        }
                    });
                });
            }
        });
        $(".batch-read").on('click',function(){
            var list = new Array();
            $(".mailbox-messages input[type='checkbox']").each(function (index, obj) {
                var id = $(this).val();
                if ($(this).is(':checked')) {
                    list.push(id);
                }
            });
            if (list.length <= 0) {
                return false;
            }
            else
            {
                $.showConfirm('您确定要标记选中的消息为已读吗？',function(){
                    $.ajax({
                        type: "POST",
                        url: "<?=$this->baseurl.'batch_read'?>",
                        data: {list: list},
                        cache: false,
                        dataType: "json",
                        success: function (res) {
                            if (res.errcode == 0) {
                                window.location.reload();
                            } else {
                                $.showErr(res.errmsg);
                                return false;
                            }
                        },
                        error: function () {
                            $.showErr('服务器繁忙,请稍后...');
                        }
                    });
                });
            }
        });
    });
</script>