<?php $this->load->view('admin/header'); ?>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')?>">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl?>">图文素材</a></li>
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
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-refresh"><i class="fa fa-refresh"></i>同步</a>
                    </div>
                    <div class="col-md-6">
                        <form class="form-horizontal pull-right" action="<?=$this->baseurl?>">
                            <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                <input type="text" name="keywords" class="form-control pull-right" placeholder="名称"  value="<?= $keywords ?>" >
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
                                <th width="8%">序号</th>
                                <th width="15%">图片</th>
                                <th>内容</th>
                                <th width="15%">最后更新时间</th>
                                <th width="15%">操作</th>
                            </tr>
                            <?php foreach ($list as $key => $value): ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><img src="<?= $value['thumb_url'] ?>" width="60" height="60"></td>
                                    <td>
                                        <table>
                                        <?php foreach($value['news_item'] as $item):?>
                                            <tr><td><?=$item['title']?></td></tr>
                                        <?php endforeach;?>
                                        </table>
                                    </td>
                                    <td><?= $value['update_time'] ?></td>
                                    <td>
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
<?php $this->load->view('admin/footer'); ?>
<script>
    $(function(){
        $(".btn-refresh").on('click',function(){
            var url='<?=$this->baseurl.'refresh'?>';
            $.ajax({
                type:'post',
                dataType:"json",
                url : url,
                beforeSend:function(){

                },
                success: function (res) {
                    if(res.errcode==0){
                        $.showSuccessTimeout('res.errmsg',2000,function(){
                            window.location.reload();
                        });
                    }else{
                        $.showErr(res.errmsg);
                        return false ;
                    }
                }
            })
        });
        $(".btn-del").on('click',function(){
            var url=$(this).attr('data-url');
            $.showConfirm('确定要删除吗？',function(){
                window.location.href=url;
            });
        });
    });
</script>