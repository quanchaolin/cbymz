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
            <li><a href="<?=$this->baseurl?>">商品列表</a></li>
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
                        <form class="form-horizontal" action="<?=$this->baseurl?>">
                            <div class="form-inline pull-right">
                                <label class="hidden-sm control-label" style="">商品分类</label>
                                <select name=" category_id" id="category_id" class="form-control select2 hidden-sm" style="width: 90px;">
                                    <option value="">全部</option>
                                    <?php foreach($category as $val):?>
                                        <option value="<?=$val['id']?>" <?php if($category_id==$val['id'])echo 'selected';?>><?=$val['name']?></option>
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
                                <th width="5%">序号</th>
                                <th width="10%">商品图片</th>
                                <th>商品名称</th>
                                <th width="8%">商品分类</th>
                                <th width="12%">回向文</th>
                                <th width="8%">商品价格</th>
                                <th width="12%">开始时间/结束时间</th>
                                <th width="20%">操作</th>
                            </tr>
                            <?php foreach ($list as $key => $value): ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td>
                                        <a href="<?=$value['main_img']?>" target="_blank">
                                            <img src="<?=$value['main_img']?>" width="64" height="64">
                                        </a>
                                    </td>
                                    <td><?= $value['name'] ?></td>
                                    <td><?= $value['category_name'] ?></td>
                                    <td><?= $value['back_paper_name'] ?></td>
                                    <td><?= $value['price'] ?></td>
                                    <td><?= $value['start_time'] ?><br><?= $value['end_time'] ?></td>
                                    <td>
                                        <span class="label label-sm <?php if($value['status']==1){echo 'label-success';}else{echo 'label-warning';}?> update-status" data-id="<?=$value['id']?>" data-status="<?=$value['status']?>"><?=config_item('status')[$value['status']]?></span>
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
            var url=$(this).attr('data-url');
            $.showConfirm('确定要删除吗？',function(){
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