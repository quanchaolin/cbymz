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
            <li><a href="<?=$this->baseurl?>">义工管理</a></li>
            <li class="active">列表</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="box-title">义工列表</h3>
                                <a class="green" href="#">
                                    <i class="fa fa-plus-circle btn-add"></i>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="form-horizontal pull-right">
                                    <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                        <input type="text" name="keywords" class="form-control pull-right" placeholder="义工名称..."  value="<?= $keywords ?>" >
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default submit"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr role="row">
                                    <th width="10%">义工姓名</th>
                                    <th width="10%">邮箱地址</th>
                                    <th width="10%">关联管理员</th>
                                    <th>负责项目</th>
                                    <th width="10%">发送到微信</th>
                                    <th width="5%">状态</th>
                                    <th width="15%">操作</th>
                                </tr>
                                </thead>
                                <tbody id="contentList"></tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix" id="userPage">

                    </div>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('admin/footer'); ?>
<?php $this->load->view('admin/page_common'); ?>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<div class="modal fade" id="dialog-item-form">
    <div class="modal-dialog">
        <form method="post" action="#" id="userForm" data-parsley-validate>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">编辑</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" role="grid">
                            <tr>
                                <td><label for="group_name">义工姓名</label></td>
                                <input type="hidden" name="id" id="id"/>
                                <td><input type="text" name="name" id="name" value="" class="form-control" data-parsley-required="true" /></td>
                            </tr>
                            <tr>
                                <td><label for="seq">邮箱地址</label></td>
                                <td><input type="email" name="email" id="email" value="" class="form-control" data-parsley-required="true" /></td>
                            </tr>
                            <tr>
                                <td style="width: 80px;"><label for="parentId">关联管理员</label></td>
                                <td>
                                    <select id="sysUserSelectId" class="form-control" name="user_id" data-placeholder="选择关联管理员" style="width: 200px;" data-parsley-required="true"></select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="userStatus">发送微信</label></td>
                                <td>
                                    <select class="form-control" id="send_weixin" name="send_weixin" data-placeholder="选择状态" style="width: 150px;">
                                        <option value="0">不发送</option>
                                        <option value="1">发送</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="status">状态</label></td>
                                <td>
                                    <select class="form-control" id="status" name="status" data-placeholder="选择状态" style="width: 150px;">
                                        <option value="0">未审核</option>
                                        <option value="1">有效</option>
                                        <option value="2">无效</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="remark">备注</label></td>
                                <td><textarea name="remark" id="remark" class="form-control" rows="3" cols="25"></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">义工负责项目</h4>
            </div>
            <div class="modal-body" style="max-height:400px;overflow-y:auto;padding: 0">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <div class="box box-primary" style="border: none;">
                        <div class="box-header with-border">
                            <div class="pull-right">
                                <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                    <input type="hidden" name="id" id="projectId" value="">
                                    <input type="text" name="product_keyword" class="form-control pull-right" placeholder="名称..."  value="" >
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default product_submit"><i class="fa fa-search"></i></button>
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
                                        <th>名称</th>
                                        <th>分类</th>
                                    </tr>
                                    </thead>
                                    <tbody id="productList">
                                    </tbody>
                                </table>
                                <!-- /.table -->
                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer no-padding">
                            <div id="productPage" >

                            </div>
                        </div>
                    </div>
                    <!-- /. box -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary btn-save">保存</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script id="contentListTemplate" type="x-tmpl-mustache">
{{#contentList}}
<tr role="row" class="user-name odd" data-id="{{id}}"><!--even -->
    <td><a href="#" class="btn-edit" data-id="{{id}}">{{name}}</a></td>
    <td>{{email}}</a></td>
    <td>{{true_name}}</a></td>
    <td>{{product_name}}</a></td>
    <td>{{send_weixin_text}}</a></td>
    <td>{{#bold}}{{/bold}}</td> <!-- 此处套用函数对status做特殊处理 -->
    <td>
        <a class="btn btn-info btn-xs btn-edit" href="#" data-id="{{id}}" data-name={{name}}>
                <i class="fa fa-pencil"></i>编辑
            </a>
            <a class="btn btn-info btn-xs btn-product-manager" href="#" data-id="{{id}}" data-name={{name}}>
                <i class="fa fa-users"></i>负责项目
            </a>
            <a class="btn btn-danger btn-xs btn-del" href="#" data-id="{{id}}" data-name={{name}}>
                <i class="fa fa-trash-o"></i>删除
            </a>
    </td>
</tr>
{{/contentList}}
</script>
<script id="productListTemplate" type="x-tmpl-mustache">
{{#productList}}
<tr role="row" class="odd" data-id="{{id}}">
    <td><input type="checkbox" name="product_sel" data-name={{name}} {{checked}} value="{{id}}"></td>
    <td>{{name}}</td>
    <td>{{category_name}}</td>
</tr>
{{/productList}}
</script>
<script>
    var sysUserList=<?=$sys_user?>; // 存储树形管理员列表
    var contentList; // 存储树形部门列表
    var contentMap = {}; // 存储map格式的用户信息
    var optionStr;
    $(function(){
        var contentListTemplate = $('#contentListTemplate').html();
        Mustache.parse(contentListTemplate);
        var productListTemplate = $('#productListTemplate').html();
        Mustache.parse(productListTemplate);
        loadContentList();
        $(".submit").click(function(){
            loadContentList();
        });
        function loadContentList() {
            var url = "<?=$this->baseurl.'lists'?>" ;
            $.ajax({
                type:'get',
                dataType:"json",
                url : url,
                success: function (result) {
                    renderUserListAndPage(result, url);
                }
            })
        }
        function renderUserListAndPage(result, url) {
            if (result.errcode==0) {
                if (result.data.total > 0){
                    contentList = result.data.data;
                    var rendered = Mustache.render(contentListTemplate, {
                        contentList: result.data.data,
                        "bold": function() {
                            return function(text, render) {
                                var status = this.status;
                                if (status == 1) {
                                    return "<span class='label label-sm label-success'>有效</span>";
                                } else if(status == 2) {
                                    return "<span class='label label-sm label-warning'>无效</span>";
                                } else {
                                    return "<span class='label'>删除</span>";
                                }
                            }
                        }
                    });
                    $("#contentList").html(rendered);
                    bindItemClick();
                    $.each(result.data.data, function(i, item) {
                        contentMap[item.id] = item;
                    });
                    var pageSize = 10;
                    var pageNo = parseInt($("#userPage .pageNo").val()) || 1;
                    renderPage(url, result.data.total, pageNo, pageSize, result.data.total > 0 ? result.data.data.length : 0, "userPage", renderUserListAndPage);
                } else {
                    $("#contentList").html('');
                }
            } else {
                $.showErr(result.errmsg);
            }
        }
        function loadProductList(id) {
            var keywords=$("input[name='product_keyword']").val()
                ,url='<?=$this->baseurl.'product_list'?>';
            if(id==0)return false;
            var pageSize = 10;
            var pageNo = $("#productPage .pageNo").val() || 1;
            $.ajax({
                type:'get',
                dataType:"json",
                url : url,
                data: {
                    id:id,
                    keywords:keywords,
                    pageSize: pageSize,
                    pageNo: pageNo
                },
                success: function (result) {
                    if (result.data.total > 0){
                        var rendered = Mustache.render(productListTemplate, {
                            productList: result.data.list
                        });
                        $("#productList").html(rendered);
                        $('#productList input[type="checkbox"]').iCheck({
                            checkboxClass: 'icheckbox_flat-blue'
                        });
                    } else {
                        $("#productList").html('');
                    }
                }
            })
        }
        //Enable check and uncheck all functionality
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
        $(".btn-add").click(function() {
            $('#id').val('');
            $("#userForm")[0].reset();
            var id=0;
            optionStr = "";
            recursiveRenderSysUserSelect(id,sysUserList);
            $("#sysUserSelectId").html(optionStr);
            $('#dialog-item-form').modal({
                backdrop: false
            });
        });
        function bindItemClick(){
            $(".btn-edit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var id = $(this).attr("data-id");
                $("#userForm")[0].reset();
                optionStr = "";
                recursiveRenderSysUserSelect(id,sysUserList);
                $("#sysUserSelectId").html(optionStr);
                var targetUser = contentMap[id];
                if (targetUser) {
                    $("#name").val(targetUser.name);
                    $("#email").val(targetUser.email);
                    $("#send_weixin").val(targetUser.send_weixin);
                    $("#remark").val(targetUser.remark);
                    $("#status").val(targetUser.status);
                    $("#id").val(targetUser.id);
                }
                $('#dialog-item-form').modal({
                    backdrop: false
                });
            });
            $(".btn-del").on('click',function(){
                var id=$(this).attr("data-id")
                    ,url='<?=$this->baseurl.'delete?id='?>'+id
                    ,name=$(this).attr("data-name");
                $.showConfirm('确定要删除【'+name+'】吗？',function(){
                    $.get(url,function(res){
                        if(res.errcode==0) {
                            loadContentList();
                        }
                        else {
                            $.showErr(res.errmsg);
                        }
                    },'json');
                });
            });
            $(".btn-product-manager").on('click',function(){
                var id=$(this).attr('data-id');
                $("#projectId").val(id);
                $('#modal-default').modal('show');
                loadProductList(id);
            });
        }
        $(".product_submit").on('click',function(){
            var id=$("#projectId").val();
            loadProductList(id);
        });
        $('#userForm').parsley().on('form:validated', function() {
            var ok = $('.parsley-error').length === 0;
            if(ok)
            {
                $('#dialog-item-form').modal('hide');
                var id=$('#id').val()
                    ,$form = $("#userForm")
                    ,data=serializeForm($form);
                $.ajax({
                    type: 'POST',
                    dataType:"json",
                    url:  "<?=$this->baseurl.'save'?>",
                    data: {id:id,value:data},
                    success: function(res) {
                        if (res.errcode==0) {
                            loadContentList();
                        } else {
                            $.showErr(res.errmsg);
                        }
                    },
                    error:function(){
                        $.showErr('服务器繁忙，请稍后...');
                    }
                });
            }
        });
        function recursiveRenderSysUserSelect(id,List) {
            optionStr+="<option value='0'>请选择</option>";
            var targetUser = contentMap[id];
            if (List && List.length > 0) {
                $(List).each(function (i, item) {
                    var selected='';
                    if (targetUser && item.id==targetUser.user_id) {
                        selected='selected';
                    }
                    optionStr += Mustache.render("<option {{selected}} value='{{id}}'>{{name}}</option>", {selected:selected,id: item.id, name:  item.true_name});
                });
            }
        }
        $(".btn-save").on('click',function(){
            var chk_value =[];
            $('input[name="product_sel"]:checked').each(function(){
                chk_value.push($(this).val());
            });
            var url='<?=$this->baseurl.'product_list_save'?>'
                ,id=$("#projectId").val();
            $.post(url,{id:id,value:chk_value},function(res){
                if(res.errcode==0){
                    $('#modal-default').modal('hide');
                    loadProductList(id);
                }else{
                    $.showErr(res.errmsg);
                }
            }, 'json');
        });
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
</script>