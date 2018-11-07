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
            <li><a href="<?=$this->baseurl?>">日行一善心愿单</a></li>
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
                        <a href="<?= $this->baseurl . 'index?sel_time=0' ?>" class="btn btn-sm <?php if($sel_time==0){echo 'btn-primary';}else{echo 'btn-default';}?>">全部</a>
                        <a href="<?= $this->baseurl . 'index?sel_time=1' ?>" class="btn btn-sm <?php if($sel_time==1){echo 'btn-primary';}else{echo 'btn-default';}?>">今天</a>
                        <a href="<?= $this->baseurl . 'index?sel_time=2' ?>" class="btn btn-sm <?php if($sel_time==2){echo 'btn-primary';}else{echo 'btn-default';}?>">昨天</a>
                        <a href="<?= $this->baseurl . 'index?sel_time=3' ?>" class="btn btn-sm <?php if($sel_time==3){echo 'btn-primary';}else{echo 'btn-default';}?>">最近一个月</a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-export"><i class="fa fa-file-excel-o"></i>导出</a>
                    </div>
                    <div class="col-md-6">
                        <form class="form-horizontal pull-right" action="<?=$this->baseurl?>">
                            <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                <input type="text" name="keywords" class="form-control pull-right" placeholder="姓名/项目"  value="<?= $keywords ?>" >
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
                                <th width="5%">序号</th>
                                <th width="8%">用户昵称</th>
                                <th >功德主名字</th>
                                <th width="10%">联系电话</th>
                                <th width="8%">供灯会供</th>
                                <th width="8%">放生护生</th>
                                <th width="8%">供养僧人</th>
                                <th width="8%">供助印经书</th>
                                <th width="8%">总共</th>
                                <th width="12%">添加时间</th>
                            </tr>
                            <?php foreach ($list as $key => $value): ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value['buyer_nick'] ?></td>
                                    <td><?= $value['receiver_name'] ?></td>
                                    <td><?= $value['receiver_mobile'] ?></td>
                                    <td><?= $value['packet_type'][1] ?></td>
                                    <td><?= $value['packet_type'][2] ?></td>
                                    <td><?= $value['packet_type'][3] ?></td>
                                    <td><?= $value['packet_type'][4] ?></td>
                                    <td><?= $value['order_total_price'] ?></td>
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
<!-- bootstrap datepicker -->
<script src="<?=base_url('static/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')?>"></script>
<script src="<?=base_url('static/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')?>"></script>
<div class="modal fade" id="dialog-export-form">
    <div class="modal-dialog">
        <form class="table-responsive" action="<?=site_url('admin/rxysh/export?start_time=')?>" method="get" id="Form" data-parsley-validate>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">日行一善导出</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-striped" role="grid">
                        <tr>
                            <td><label for="aclModuleName">开始时间</label></td>
                            <td><input type="text" name="start_time" id="start_time" value="" class="form-control form_datetime" data-parsley-required="true"></td>
                        </tr>
                        <tr>
                            <td><label for="aclModuleSeq">结束时间</label></td>
                            <td><input type="text" name="end_time" id="end_time" value="" class="form-control form_datetime" data-parsley-required="true"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">导出</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(function(){
        $('.btn-export').on('click',function() {
            var start_time = '<?=$this->start_time?>';
            var end_time = '<?=$this->end_time?>';
            $("#start_time").val(start_time);
            $("#end_time").val(end_time);
            $('#dialog-export-form').modal({
                backdrop: false
            });
        });
        $('#Form').parsley().on('form:validated', function() {
            var ok = $('#Form .parsley-error').length === 0;
            if(ok)
            {
                $('#dialog-export-form').modal('hide');
            }
        });
        $('.form_datetime').datetimepicker({
            autoclose: true,
            todayHighlight: true,
            language:"zh-CN", //语言设置
            format: 'yyyy-mm-dd hh:ii:ss'
        });
        $(".btn-del").on('click',function(){
            var url=$(this).attr('data-url');
            $.showConfirm('确定要删除吗？',function(){
                window.location.href=url;
            });
        });
    });
</script>