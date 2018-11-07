<?php $this->load->view('admin/header'); ?>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')?>">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')?>">
<link type="text/css" rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-fileinput/css/fileinput.min.css')?>" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl?>">微信对账</a></li>
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
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-add"><i class="fa fa-file-excel-o"></i> 导入</a>
                    </div>
                    <div class="col-md-10">
                        <form class="form-horizontal" action="<?=$this->baseurl?>" method="get">
                            <div class="form-inline pull-right">
                                <label class="hidden-sm control-label" style="">支付状态</label>
                                <select name="status" id="status" class="form-control select2 hidden-sm" style="width: 90px;">
                                    <option value="all">全部</option>
                                    <?php foreach($this->order_status as $key=>$val):?>
                                        <option value="<?=$key?>" <?php if($status==$key)echo 'selected';?>><?=$val?></option>
                                    <?php endforeach;?>
                                </select>
                                <label class="control-label">开始时间</label>
                                <input type="text" name="start_date" value="<?=$start_date?>" class="form-control form_datetime" style="width: 117px;"/>
                                <label class="control-label">结束时间</label>
                                <input type="text" name="end_date" value="<?=$end_date?>" class="form-control form_datetime" style="width: 117px;"/>

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
                                <th>商品名称</th>
                                <th>商户订单号</th>
                                <th>交易总金额</th>
                                <th>真实业务结果</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($list as $key => $value): ?>
                                <tr>
                                    <td width="5%"><?= $key+1 ?></td>
                                    <td width="30%"><?= $value['product_name'] ?></td>
                                    <td width="15%"><?= $value['out_trade_no'] ?><br/><?= $value['trans_id'] ?></td>
                                    <td width="15%"><?= $value['total_fee'] ?><br/><?= $value['order_total_price'] ?></td>
                                    <td width="15%"><?= $value['trade_status'] ?><br/><?= $value['status_text'] ?></td>
                                    <td>
                                        <span class="label label-sm <?php if($value['status']==1){echo 'label-success';}else{echo 'label-warning';}?> update-status" data-id="<?=$value['id']?>" data-status="<?=$value['status']?>"><?=$this->order_status[$value['status']]?></span>
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
                <h4 class="modal-title">导入</h4>
            </div>
            <div class="modal-body" style="max-height:400px;overflow-y:auto;padding: 0">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <div class="box box-primary" style="border: none;">
                       <div class="form-label col-md-2">文件</div>
                        <input  type="hidden" name="filename" value=""/>
                        <div class="file-loading">
                            <input id="excel" name="file" type="file" multiple>
                        </div>
                        <div id="kv-error-1" style="margin-top:10px;display:none"></div>
                        <div id="kv-success-1" class="alert alert-success" style="margin-top:10px;display:none"></div>
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
<!-- bootstrap datepicker -->
<script src="<?=base_url('static/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('static/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-CN.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/plugins/bootstrap-fileinput/js/fileinput.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/plugins/bootstrap-fileinput/js/locales/zh.js')?>"></script>
<script>
    $(function(){
        $('.btn-add').on('click',function(){
            $("#modal-default").modal('show');
        });
        $("#excel").fileinput({
            uploadUrl: "<?=site_url('admin/file/excel_upload/')?>",
            uploadAsync: true,
            showPreview: false,
            language : 'zh',
            allowedFileExtensions: ['xls', 'xlsx','csv'],
            maxFileCount: 1,
            elErrorContainer: '#kv-error-1'
        }).on('filebatchpreupload', function(event, data, id, index) {
            $('#kv-success-1').html('<h4>上传状态</h4><ul></ul>').hide();
        }).on('fileuploaded', function(event, data, id, index) {
            var url=data.response.url;
            $("input[name='filename']").val(url);
        });

        $(".btn-save").on('click',function(){
            var url='<?=$this->baseurl.'importExecl'?>';
            var filename=$("input[name='filename']").val();
            if(filename=='')
            {
                alert('请先选择文件！');
                return false;
            }
            $.post(url,{filename:filename},function(res){
                if(res.errcode==0){
                    $.showSuccessTimeout(res.errmsg,3000,function(){});
                    $('#modal-default').modal('hide');
                    window.location.reload();
                }else{
                    $.showErr(res.errmsg);
                }
            }, 'json');
        });
        $('.form_datetime').datepicker({
            autoclose: true,
            todayHighlight: true,
            language:"zh-CN", //语言设置
            format: 'yyyy-mm-dd'
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