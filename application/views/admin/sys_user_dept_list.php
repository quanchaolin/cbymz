<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-treeview/dist/bootstrap-treeview.min.css')?>"/>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl.'dept'?>">用户管理（按部门）</a></li>
            <li class="active">列表</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">部门列表</h3>
                        <input type="hidden" name="dept_id" id="dept_id"/>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding" id="treeview">
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">用户列表</h3>
                        <a class="green" href="#">
                            <i class="fa fa-plus-circle user-add"></i>
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-header with-border">
                        <!--<div class="row"><div class="col-sm-6"><div class="dataTables_length" id="example1_length"><label>Show <select name="example1_length" aria-controls="example1" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-6"><div id="example1_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="example1"></label></div></div>
                        </div>-->
                        <div class="col-sm-6">
                            <label style="font-weight: normal;text-align:left;white-space: nowrap;">
                                展示
                                <select id="pageSize" name="dynamic-table_length" aria-controls="dynamic-table" class="form-control input-sm" style="width: 75px;display: inline-block;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> 条记录 </label>
                        </div>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <div class="pull-right">
                                    <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                        <input type="text" name="keywords" class="form-control pull-right" placeholder="姓名..."  value="" >
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default submit"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr role="row">
                                    <th>姓名</th>
                                    <th>用户名</th>
                                    <th>电话</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody id="userList"></tbody>
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
<?php $this->load->view('admin/page'); ?>
<!-- query.cxselect.js -->
<script src="<?=base_url('static/plugins/bootstrap-treeview/dist/bootstrap-treeview.min.js')?>"></script>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<div class="modal fade" id="dialog-user-form">
    <div class="modal-dialog">
        <form method="post" action="#" id="userForm" data-parsley-validate>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">标题</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" role="grid">
                            <tr>
                                <td style="width: 80px;"><label for="parentId">所在部门</label></td>
                                <td>
                                    <select id="deptSelectId" class="form-control" name="dept_id" data-placeholder="选择部门" style="width: 200px;"></select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 80px;"><label for="parentId">角色</label></td>
                                <td>
                                    <select id="roleSelectId" class="form-control" name="role_id" data-placeholder="选择角色" style="width: 200px;" data-parsley-required="true"></select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="userName">姓名</label></td>
                                <input type="hidden" name="id" id="userId"/>
                                <td><input type="text" name="true_name" id="trueName" value="" class="form-control" data-parsley-required="true" /></td>
                            </tr>
                            <tr>
                                <td><label for="userTelephone">电话</label></td>
                                <td><input type="text" name="telephone" id="userTelephone" value="" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><label for="userMail">邮箱</label></td>
                                <td><input type="email" name="mail" id="userMail" value="" class="form-control" data-parsley-required="true"></td>
                            </tr>
                            <tr>
                                <td><label for="userStatus">状态</label></td>
                                <td>
                                    <select class="form-control" id="userStatus" name="status" data-placeholder="选择状态" style="width: 150px;">
                                        <option value="1">有效</option>
                                        <option value="2">无效</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="userRemark">备注</label></td>
                                <td><textarea name="remark" id="userRemark" class="form-control" rows="3" cols="25"></textarea></td>
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
<script id="userListTemplate" type="x-tmpl-mustache">
{{#userList}}
<tr role="row" class="user-name odd" data-id="{{id}}"><!--even -->
    <td><a href="#" class="btn-edit" data-id="{{id}}">{{true_name}}</a></td>
    <td>{{username}}</td>
    <td>{{telephone}}</td>
    <td>{{#bold}}{{/bold}}</td> <!-- 此处套用函数对status做特殊处理 -->
    <td>
        <a class="btn btn-info btn-xs btn-edit" href="#" data-id="{{id}}" data-name={{name}}>
                <i class="fa fa-pencil"></i>编辑
            </a>
            <a class="btn btn-danger btn-xs btn-del" href="#" data-id="{{id}}" data-name={{true_name}}>
                <i class="fa fa-trash-o"></i>删除
            </a>
    </td>
</tr>
{{/userList}}
</script>
<script>
    var deptList=<?=$dept_data?>; // 存储树形部门列表
    var roleList=<?=$role_list?>;
    var userMap = {}; // 存储map格式的用户信息
    var optionStr;
    var deptOptionStr;
    $(function(){
        $('#treeview').treeview({
            color: "#428bca",
            expandIcon: 'glyphicon glyphicon-chevron-right',
            collapseIcon: 'glyphicon glyphicon-chevron-down',
            nodeIcon: 'glyphicon glyphicon-bookmark',
            data:deptList
        });
        $('#treeview').on('nodeSelected', function(event, data) {
            var dept_id=data.id;
            $("#dept_id").val(dept_id);
            loadUserList(dept_id);
        });
        var userListTemplate = $('#userListTemplate').html();
        Mustache.parse(userListTemplate);
        $(".submit").click(function(){
            var dept_id=$("#dept_id").val();
            loadUserList(dept_id);
        });
        function loadUserList(dept_id) {
            var pageSize = $("#pageSize").val();
            var url = "<?=$this->baseurl.'user_dept_list?id='?>" + dept_id;
            var pageNo = $("#userPage .pageNo").val() || 1;
            var keywords=$("input[name='keywords']").val();
            $.ajax({
                type:'get',
                dataType:"json",
                url : url,
                data: {
                    keywords:keywords,
                    pageSize: pageSize,
                    pageNo: pageNo
                },
                success: function (result) {
                    renderUserListAndPage(result, url);
                }
            })
        }
        function renderUserListAndPage(result, url) {
            if (result.errcode==0) {
                if (result.data.total > 0){
                    var rendered = Mustache.render(userListTemplate, {
                        userList: result.data.data,
                        "bold": function() {
                            return function(text, render) {
                                var status = this.status;
                                if (status ==1) {
                                    return "<span class='label label-sm label-success'>有效</span>";
                                } else if(status == 2) {
                                    return "<span class='label label-sm label-warning'>无效</span>";
                                } else {
                                    return "<span class='label'>删除</span>";
                                }
                            }
                        }
                    });
                    $("#userList").html(rendered);
                    bindUserClick();
                    $.each(result.data.data, function(i, user) {
                        userMap[user.id] = user;
                    })
                } else {
                    $("#userList").html('');
                }
                var pageSize = $("#pageSize").val();
                var pageNo = parseInt($("#userPage .pageNo").val()) || 1;
                renderPage(url, result.data.total, pageNo, pageSize, result.data.total > 0 ? result.data.data.length : 0, "userPage", renderUserListAndPage);
            } else {
                $.showErr(result.errmsg);
            }
        }
        $(".user-add").click(function() {
            $('#userId').val('');
            $("#userForm")[0].reset();
            optionStr = "";
            recursiveRenderRoleSelect(roleList);
            deptOptionStr='';
            recursiveRenderDeptSelect(deptList);
            $("#deptSelectId").html(deptOptionStr);
            $("#roleSelectId").html(optionStr);
            $('#dialog-user-form').modal({
                backdrop: false
            });
        });
        function bindUserClick(){
            $(".btn-edit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var userId = $(this).attr("data-id");
                optionStr = "";
                $("#deptSelectId").html('');
                recursiveRenderRoleSelect(roleList,userId);
                deptOptionStr='';
                recursiveRenderDeptSelect(deptList);
                $("#deptSelectId").html(deptOptionStr);
                $("#userForm")[0].reset();
                $("#roleSelectId").html(optionStr);
                var targetUser = userMap[userId];
                if (targetUser) {
                    $("#trueName").val(targetUser.true_name);
                    $("#userMail").val(targetUser.mail);
                    $("#userTelephone").val(targetUser.telephone);
                    $("#userStatus").val(targetUser.status);
                    $("#userRemark").val(targetUser.remark);
                    $("#userId").val(targetUser.id);
                }
                $('#dialog-user-form').modal({
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
                            var dept_id=$("#dept_id").val();
                            loadUserList(dept_id);
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
                $('#dialog-user-form').modal('hide');
                var id=$('#userId').val()
                    ,$form = $("#userForm")
                    ,data=serializeForm($form);
                $.ajax({
                    type: 'POST',
                    dataType:"json",
                    url:  "<?=$this->baseurl.'save'?>",
                    data: {id:id,value:data},
                    success: function(res) {
                        if (res.errcode==0) {
                            var dept_id=$("#dept_id").val();
                            loadUserList(dept_id);
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
        function recursiveRenderRoleSelect(roleList,userId) {
            userId = userId | 0;
            optionStr+='<option value="">请选择</option>';
            if (roleList && roleList.length > 0) {
                $(roleList).each(function (i, role) {
                    var targetUser = userMap[userId];
                    var selected='';
                    if (targetUser && role.id==targetUser.role_id) {
                        selected='selected';
                    }
                    optionStr += Mustache.render("<option {{selected}} value='{{id}}'>{{name}}</option>", {selected:selected,id: role.id, name:  role.name});
                });
            }
        }
        function recursiveRenderDeptSelect(deptList,level) {
            var userId = $("#userId").val();
            level = level | 1;
            var targetUser = userMap[userId];
            if (deptList && deptList.length > 0) {
                $(deptList).each(function (i, dept) {
                    var selected='';
                    if (targetUser && dept.id==targetUser.dept_id) {
                        selected='selected';
                    }
                    var blank = "";
                    if (level > 1) {
                        for(var j = 3; j <= level; j++) {
                            blank += "..";
                        }
                        blank += "∟";
                    }
                    deptOptionStr += Mustache.render("<option {{selected}} value='{{id}}'>{{name}}</option>", {selected:selected,id: dept.id, name: blank + dept.text});
                    if (dept.child && dept.child.length > 0) {
                        recursiveRenderDeptSelect(dept.child, level + 1);
                    }
                });
            }
        }
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
</script>