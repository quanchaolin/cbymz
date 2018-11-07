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
            <li><a href="<?=$this->baseurl?>">数据备份</a></li>
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
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-add"><i class="fa fa-plus"></i> 新建备份</a>
                    </div>
                    <div class="col-md-6 ">
                        <form class="form-horizontal pull-right" action="<?=$this->baseurl?>">
                            <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                <input type="text" name="keywords" class="form-control pull-right" placeholder="文件名..."  value="<?= $keywords ?>" >
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
                                <th>文件名</th>
                                <th>文件大小</th>
                                <th>类型</th>
                                <th>下载次数</th>
                                <th>备份时间</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($list as $key => $value): ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value['name'] ?></td>
                                    <td><?= $value['size'] ?></td>
                                    <td><?= $value['type'] ?></td>
                                    <td><?= $value['downloads'] ?></td>
                                    <td><?= $value['add_time'] ?></td>
                                    <td>
                                        <a href="<?= $this->baseurl . 'download?id=' . $value['id'] ?>"  class="btn btn-primary btn-xs">下载</a>
                                        <a href="javascript:void(0);" class="btn btn-info btn-xs btn-edit" data-id="<?=$value['id']?>" data-title="<?= $value['name'] ?>"><i class="fa fa-pencil"></i> 编辑 </a>
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
        $('.btn-edit').on('click',function(){
            var id=$(this).attr('data-id')
                ,title=$(this).attr('data-title');
            BootstrapDialog.show({
                title: '编辑',
                message: $('<input type="hidden" name="id" value="'+id+'"><input type="text" name="title" value="'+title+'" class="form-control" />'),
                buttons: [{
                    label: '保存',
                    cssClass: 'btn-primary',
                    hotkey: 13, // Enter.
                    action: function() {
                        var id=$("input[name='id']").val(),
                            title=$("input[name='title']").val()
                            ,url="<?=$this->baseurl?>save";
                        var data_ = {
                            name:title
                        } ;
                        $.ajax({
                            type: "POST",
                            url: url ,
                            data: {id:id,value:data_},
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
                                layer.msg('服务器繁忙,请稍后...');
                            }
                        });
                    }
                }, {
                    label: '关闭',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
            });
        });
        $('.btn-add').on('click',function(){
            var id=$(this).attr('data-id')
                ,url="<?=$this->baseurl?>backup";
            $.ajax({
                type: "POST",
                url: url ,
                data: {id:id},
                cache:false,
                dataType:"json",
                beforeSend:function(){

                },
                complete:function(){

                },
                success: function(res){
                    if(res.errcode==0){
                        $.showSuccessTimeout(res.errmsg,3000,function(){
                            window.location.reload();
                        });
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
    });
</script>