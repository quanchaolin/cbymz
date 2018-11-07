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
            <li><a href="<?=$this->baseurl.'index?type='.$this->type?>">消息提醒</a></li>
            <li class="active">详情页</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="box-title" href="javascript:history.back();">
                    <返回&nbsp;&nbsp;
                    </a>
                </h3>
                <div class="box-tools pull-right">
                    <?php if($pre_value){?>
                    <a href="<?=$this->baseurl.'detail?id='.$pre_value['id']?>" class="btn btn-box-tool" data-toggle="tooltip" title="<?=$pre_value['title']?>" data-original-title="上一篇"><i class="fa fa-chevron-left"></i></a>
                    <?php }?>
                    <?php if($next_value){?>
                    <a href="<?=$this->baseurl.'detail?id='.$next_value['id']?>" class="btn btn-box-tool" data-toggle="tooltip" title="<?=$next_value['title']?>" data-original-title="下一篇"><i class="fa fa-chevron-right"></i></a>
                    <?php }?>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-read-info">
                    <h3><?=$value['title']?></h3>
                    <h5>来自: 慈悲圆满洲
                        <span class="mailbox-read-time pull-right"><?=$value['add_time']?></span></h5>
                </div>
                <!-- /.mailbox-controls -->
                <div class="mailbox-read-message">
                    <p><?=$value['content']?></p>
                </div>
                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
            <div class="box-footer">
                <button type="button" class="btn btn-default btn-del" data-url="<?=$this->baseurl.'delete?id='.$value['id']?>"><i class="fa fa-trash-o"></i> 删除</button>
                <!--<button type="button" class="btn btn-default clip_button"><i class="fa fa-copy"></i> 复制</button>-->
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->

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
    });
</script>