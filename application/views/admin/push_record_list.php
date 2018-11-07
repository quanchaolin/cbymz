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
            <li><a href="JavaScript:history.back(-1)">消息推送</a></li>
            <li class="active">列表</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
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
                                <th>发送人数</th>
                                <th>成功人数</th>
                                <th>发送时间</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($list as $key => $value): ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value['title'] ?></td>
                                    <td><?= $value['total'] ?></td>
                                    <td><?= $value['total_success'] ?></td>
                                    <td><?= $value['add_time'] ?></td>
                                    <td>
                                        <span class="label label-sm <?php if($value['status']==1){echo 'label-success';}else{echo 'label-warning';}?> update-status" data-id="<?=$value['id']?>" data-status="<?=$value['status']?>"><?=config_item('status')[$value['status']]?></span>
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
<?php $this->load->view('admin/footer'); ?>
<script>
    $(function(){
        $(".btn-del").on('click',function(){
            var url=$(this).attr('data-url')
                ,title=$(this).attr('data-title');
            $.showConfirm('确定要删除【'+title+'】吗？',function(){
                window.location.href=url;
            });
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