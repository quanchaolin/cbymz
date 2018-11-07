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
            <li><a href="<?=$this->baseurl?>">商品分类管理</a></li>
            <li class="active">列表</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">分类列表</h3>
                        <a class="green" href="#">
                            <i class="fa fa-plus-circle btn-add"></i>
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr role="row">
                                    <th>分类名称</th>
                                    <th>备注</th>
                                    <th>状态</th>
                                    <th>操作</th>
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
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<div class="modal fade" id="dialog-content-form">
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
                                <td style="width: 80px;"><label for="pid">上级分类</label></td>
                                <td>
                                    <select id="pid" class="form-control" name="pid" data-placeholder="选择分类"></select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="name">分类名称</label></td>
                                <input type="hidden" name="id" id="id"/>
                                <td><input type="text" name="name" id="name" value="" class="form-control" data-parsley-required="true" /></td>
                            </tr>
                            <tr>
                                <td><label for="order">顺序</label></td>
                                <td><input type="text" name="order" id="order" value="" class="form-control" data-parsley-required="true" data-parsley-min="0"/></td>
                            </tr>
                            <tr>
                                <td><label for="status">状态</label></td>
                                <td>
                                    <select class="form-control" id="status" name="status" data-placeholder="选择状态" style="width: 150px;">
                                        <option value="1">有效</option>
                                        <option value="2">无效</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="description">备注</label></td>
                                <td><textarea name="description" id="description" class="form-control" rows="3" cols="25"></textarea></td>
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
<script id="contentListTemplate" type="x-tmpl-mustache">
{{#contentList}}
<tr role="row" class="user-name odd" data-id="{{id}}"><!--even -->
    <td><a href="#" class="btn-edit" data-id="{{id}}">{{html}}{{name}}</a></td>
    <td>{{description}}</a></td>
    <td>{{#bold}}{{/bold}}</td> <!-- 此处套用函数对status做特殊处理 -->
    <td>
        <a class="btn btn-info btn-xs btn-edit" href="#" data-id="{{id}}" data-name={{name}}>
                <i class="fa fa-pencil"></i>编辑
            </a>
            <a class="btn btn-danger btn-xs btn-del" href="#" data-id="{{id}}" data-name={{name}}>
                <i class="fa fa-trash-o"></i>删除
            </a>
    </td>
</tr>
{{/contentList}}
</script>
<script>
    var contentList; // 存储树形部门列表
    var optionStr = "";
    var contentMap = {}; // 存储map格式的用户信息
    $(function(){
        var contentListTemplate = $('#contentListTemplate').html();
        Mustache.parse(contentListTemplate);
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
                        contentList: result.data.list,
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
                    $.each(result.data.list, function(i, item) {
                        contentMap[item.id] = item;
                    })
                } else {
                    $("#contentList").html('');
                }
            } else {
                $.showErr(result.errmsg);
            }
        }


        $(".btn-add").click(function() {
            $('#id').val('');
            optionStr = "";
            recursiveRenderContentSelect();
            $("#userForm")[0].reset();
            $("#pid").html(optionStr);
            $('#dialog-content-form').modal({
                backdrop: false
            });
        });
        function bindItemClick(){
            $(".btn-edit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var id = $(this).attr("data-id");
                optionStr = "";
                recursiveRenderContentSelect(id);
                $("#userForm")[0].reset();
                $("#pid").html(optionStr);
                var targetUser = contentMap[id];
                if (targetUser) {
                    $("#name").val(targetUser.name);
                    $("#order").val(targetUser.order);
                    $("#description").val(targetUser.description);
                    $("#status").val(targetUser.status);
                    $("#id").val(targetUser.id);
                }
                $('#dialog-content-form').modal({
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
        }
        $('#userForm').parsley().on('form:validated', function() {
            var ok = $('.parsley-error').length === 0;
            if(ok)
            {
                $('#dialog-content-form').modal('hide');
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
        function recursiveRenderContentSelect(id) {
            optionStr+='<option value='+""+'>--</option>';
            id = id | 0;
            var targetDept = contentMap[id];
            if (contentList && contentList.length > 0) {
                $(contentList).each(function (i, dept) {
                    var selected=''
                        ,disable='';
                    if (targetDept && dept.id==targetDept.pid) {
                        selected='selected';
                    }
                    if(targetDept && dept.id==targetDept.id)
                    {
                        disable='disabled';
                    }
                    optionStr += Mustache.render("<option {{selected}} {{disable}} value='{{id}}'>{{name}}</option>", {selected:selected,disable:disable,id: dept.id, name: dept.html+ dept.name});
                });
            }
        }
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
</script>