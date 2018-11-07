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
            <li><a href="<?=$this->baseurl?>">登录日志</a></li>
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
                    <div class="col-md-6">
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-export"><i class="fa fa-file-excel-o"></i>导出</a>
                    </div>
                    <div class="col-md-6">
                        <form class="form-horizontal pull-right" action="<?=$this->baseurl?>">
                            <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                <input type="text" name="keywords" class="form-control pull-right" placeholder="用户名..."  value="<?= $keywords ?>" >
                                <div class="input-group-btn">
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
                                <th>用户名</th>
                                <th>IP地址</th>
                                <th>url</th>
                                <th>客户端信息</th>
                                <th>添加时间</th>
                            </tr>
                            <?php foreach ($list as $key => $value): ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value['true_name'] ?></td>
                                    <td><?= $value['ip'] ?></td>
                                    <td><?= $value['url'] ?></td>
                                    <td><?= $value['user_agent'] ?></td>
                                    <td><?= $value['add_time'] ?></td>
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