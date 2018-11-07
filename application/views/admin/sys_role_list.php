<?php $this->load->view('admin/header'); ?>
<!---parsley.css--->
<link href="<?=base_url('static/plugins/parsleyjs/src/parsley.css')?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?=base_url('static/plugins/ztree/zTreeStyle.css')?>" type="text/css">
<link rel="stylesheet" href="<?=base_url('static/plugins/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css')?>" type="text/css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
            <small>维护角色与用户, 角色与权限关系</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="#">角色管理</a></li>
            <li class="active">列表</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">角色列表</h3>
                        <a class="green" href="javascript:void(0);">
                            <i class="fa fa-plus-circle role-add"></i>
                        </a>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding" id="roleList">

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom tabbable" id="roleTab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#roleAclTab" data-toggle="tab">角色与权限</a></li>
                        <li><a href="#roleUserTab" data-toggle="tab">角色与用户</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="roleAclTab" class="tab-pane fade in active">
                            <ul id="roleAclTree" class="ztree"></ul>
                            <button class="btn btn-info saveRoleAcl" type="button">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                保存
                            </button>
                        </div>

                        <div id="roleUserTab" class="tab-pane fade" >
                            <div class="row">
                                <div class="box1 col-md-6">待选用户列表</div>
                                <div class="box1 col-md-6">已选用户列表</div>
                            </div>
                            <select multiple="multiple" size="10" name="roleUserList" id="roleUserList" >
                            </select>
                            <div class="hr hr-16 hr-dotted"></div>
                            <button class="btn btn-info saveRoleUser" type="button">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                保存
                            </button>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('admin/footer'); ?>
<!-- Parsley -->
<script src="<?=base_url('static/plugins/parsleyjs/dist/parsley.min.js')?>"></script>
<script src="<?=base_url('static/plugins/parsleyjs/dist/i18n/zh_cn.js')?>"></script>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/plugins/ztree/jquery.ztree.all.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/plugins/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js')?>"></script>
<div class="modal fade" id="dialog-role-form">
    <div class="modal-dialog">
        <form method="post" action="#" id="roleForm" data-parsley-validate>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">角色管理</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" role="grid">
                            <tr>
                                <td><label for="roleName">角色名称</label></td>
                                <td>
                                    <input type="text" name="name" id="roleName" value="" class="form-control" data-parsley-required="true" />
                                    <input type="hidden" name="id" id="roleId"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="roleStatus">状态</label></td>
                                <td>
                                    <select class="form-control" id="roleStatus" name="status" data-placeholder="状态" style="width: 150px;">
                                        <option value="1">可用</option>
                                        <option value="0">冻结</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            <td><label for="roleRemark">备注</label></td>
                            <td><textarea name="remark" id="roleRemark" class="form-control" rows="3" cols="25"></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>

<script id="roleListTemplate" type="x-tmpl-mustache">
<ul class="nav nav-pills nav-stacked">
    {{#roleList}}
    <li class="role-name" id="role_{{id}}" href="javascript:void(0)" data-id="{{id}}">
        <a href="#"> {{name}}
            {{#edit_string}}
                <div class="pull-right">
                  <span style="display: inline-block;" class="label label-primary role-edit" data-id="{{id}}"><i class="fa fa-pencil"></i></span>
                  <span style="display: inline-block;" class="label label-danger role-delete" data-id="{{id}}" data-name="{{name}}"><i class="fa fa-trash-o"></i></span>
                </div>
          {{/edit_string}}
          </a>
    </li>
    {{/roleList}}
</ul>
</script>

<script id="selectedUsersTemplate" type="x-tmpl-mustache">
{{#userList}}
    <option value="{{id}}" selected="selected">{{username}}--{{true_name}}</option>
{{/userList}}
</script>

<script id="unSelectedUsersTemplate" type="x-tmpl-mustache">
{{#userList}}
    <option value="{{id}}">{{username}}--{{true_name}}({{area_name}})</option>
{{/userList}}
</script>

<script type="text/javascript">
    $(function () {
        var roleMap = {};
        var lastRoleId = -1;
        var selectFirstTab = true;
        var hasMultiSelect = false;

        var roleListTemplate = $("#roleListTemplate").html();
        Mustache.parse(roleListTemplate);
        var selectedUsersTemplate = $("#selectedUsersTemplate").html();
        Mustache.parse(selectedUsersTemplate);
        var unSelectedUsersTemplate = $("#unSelectedUsersTemplate").html();
        Mustache.parse(unSelectedUsersTemplate);

        loadRoleList();

        // zTree
        <!-- 树结构相关 开始 -->
        var zTreeObj = [];
        var modulePrefix = 'm_';
        var aclPrefix = 'a_';
        var nodeMap = {};

        var setting = {
            check: {
                enable: true,
                chkDisabledInherit: true,
                chkboxType: {"Y": "ps", "N": "ps"}, //auto check 父节点 子节点
                autoCheckTrigger: true
            },
            data: {
                simpleData: {
                    enable: true,
                    rootPId: 0
                }
            },
            callback: {
                onClick: onClickTreeNode
            }
        };

        function onClickTreeNode(e, treeId, treeNode) { // 绑定单击事件
            var zTree = $.fn.zTree.getZTreeObj("roleAclTree");
            zTree.expandNode(treeNode);
        }

        function loadRoleList() {
            $.ajax({
                type:'post',
                dataType:'json',
                url: "<?=$this->baseurl.'lists'?>",
                success: function (res) {
                    if (res.errcode==0) {
                        var rendered = Mustache.render(roleListTemplate, {
                            roleList: res.data,
                            "edit_string":function(){
                                if(this.id!=1)
                                {
                                    return true;
                                }
                            }
                        });
                        $("#roleList").html(rendered);
                        bindRoleClick();
                        $.each(res.data, function(i, role) {
                            roleMap[role.id] = role;
                        });
                    } else {
                        $.showErr("加载角色列表"+res.errmsg);
                    }
                }
            });
        }
        function bindRoleClick() {
            $(".role-edit").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                var roleId = $(this).attr("data-id");
                $("#roleForm")[0].reset();
                var targetRole = roleMap[roleId];
                if (targetRole) {
                    $("#roleId").val(roleId);
                    $("#roleName").val(targetRole.name);
                    $("#roleStatus").val(targetRole.status);
                    $("#roleRemark").val(targetRole.remark);
                }
                $('#dialog-role-form').modal({
                    backdrop: false
                });
            });
            $(".role-delete").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                var roleId = $(this).attr("data-id");
                var roleName = $(this).attr("data-name");
                if (confirm("确定要删除角色[" + roleName + "]吗?")) {
                    $.ajax({
                        type:'post',
                        dataType:"json",
                        url: "<?=$this->baseurl.'delete'?>",
                        data: {
                            id: roleId
                        },
                        success: function (res) {
                            if (res.errcode==0) {
                                $.showSuccessTimeout("删除角色[" + roleName + "]"+res.errmsg,3000,function(){
                                    loadRoleList();
                                });
                            } else {
                                $.showErr("删除角色[" + roleName + "]"+res.errmsg);
                            }
                        }
                    });
                }
            });
            $(".role-name").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                var roleId = $(this).attr("data-id");
                handleRoleSelected(roleId);
                $(this).siblings().removeClass("active");
                $(this).addClass("active");
            });
        }

        function handleRoleSelected(roleId) {
            /*if (lastRoleId != -1) {
                var lastRole = $("#role_" + lastRoleId );
                lastRole.removeClass("active");
            }
            var currentRole = $("#role_" + roleId );
            currentRole.addClass("active");*/
            lastRoleId = roleId;

            $('#roleTab a:first').trigger('click');
            if (selectFirstTab) {
                loadRoleAcl(roleId);
            }
        }

        function loadRoleAcl(selectedRoleId) {
            if (selectedRoleId == -1) {
                return;
            }
            $.ajax({
                type: 'POST',
                dataType:'json',
                url: "<?=$this->baseurl.'tree'?>",
                data : {
                    roleId: selectedRoleId
                },
                success: function (result) {
                    if (result.errcode==0) {
                        renderRoleTree(result.data);
                    } else {
                        $.showErr("加载角色权限数据"+result.errmsg);
                    }
                }
            });
        }

        function getTreeSelectedId() {
            var treeObj = $.fn.zTree.getZTreeObj("roleAclTree");
            var nodes = treeObj.getCheckedNodes(true);
            var v = "";
            for(var i = 0; i < nodes.length; i++) {
                if(nodes[i].id.startsWith(aclPrefix)) {
                    v += "," + nodes[i].dataId;
                }
            }
            return v.length > 0 ? v.substring(1): v;
        }

        function renderRoleTree(aclModuleList) {
            zTreeObj = [];
            recursivePrepareTreeData(aclModuleList);
            for(var key in nodeMap) {
                zTreeObj.push(nodeMap[key]);
            }
            $.fn.zTree.init($("#roleAclTree"), setting, zTreeObj);
        }

        function recursivePrepareTreeData(aclModuleList) {
            // prepare nodeMap
            if (aclModuleList && aclModuleList.length > 0) {
                $(aclModuleList).each(function(i, aclModule) {
                    var hasChecked = false;
                    if (aclModule.aclList && aclModule.aclList.length > 0) {
                        $(aclModule.aclList).each(function(i, acl) {
                            zTreeObj.push({
                                id: aclPrefix + acl.id,
                                pId: modulePrefix + acl.acl_module_id,
                                name: acl.name + ((acl.type == 1) ? '(菜单)' : ''),
                                chkDisabled: !acl.hasAcl,
                                checked: acl.checked,
                                dataId: acl.id
                            });
                            if(acl.checked) {
                                hasChecked = true;
                            }
                        });
                    }
                    if ((aclModule.aclModuleList && aclModule.aclModuleList.length > 0) ||
                        (aclModule.aclList && aclModule.aclList.length > 0)) {
                        nodeMap[modulePrefix + aclModule.id] = {
                            id : modulePrefix + aclModule.id,
                            pId: modulePrefix + aclModule.pid,
                            name: aclModule.name,
                            open: hasChecked
                        };
                        var tempAclModule = nodeMap[modulePrefix + aclModule.id];
                        while(hasChecked && tempAclModule) {
                            if(tempAclModule) {
                                nodeMap[tempAclModule.id] = {
                                    id: tempAclModule.id,
                                    pId: tempAclModule.pId,
                                    name: tempAclModule.name,
                                    open: true
                                }
                            }
                            tempAclModule = nodeMap[tempAclModule.pid];
                        }
                    }
                    recursivePrepareTreeData(aclModule.aclModuleList);
                });
            }
        }

        $(".role-add").click(function () {
            $("#roleId").val('');
            $("#roleForm")[0].reset();
            $('#dialog-role-form').modal({
                backdrop: false
            });
        });

        $(".saveRoleAcl").click(function (e) {
            e.preventDefault();
            if (lastRoleId == -1) {
                $.showErr("保存角色与权限点的关系，请现在左侧选择需要操作的角色");
                return;
            }
            $.ajax({
                type: 'POST',
                dataType:'json',
                url: "<?=$this->baseurl.'change_acl'?>",
                data: {
                    roleId: lastRoleId,
                    aclIds: getTreeSelectedId()
                },
                success: function (result) {
                    if (result.errcode==0) {
                        $.showSuccessTimeout("保存角色与权限点的关系"+result.errmsg,3000,function(){
                        });
                    } else {
                        $.showErr("保存角色与权限点的关系"+result.errmsg);
                    }
                }
            });
        });
        $('#roleForm').parsley().on('form:validated', function() {
            var ok = $('.parsley-error').length === 0;
            if(ok)
            {
                $('#dialog-role-form').modal('hide');
                var id=$('#roleId').val()
                    ,$form = $("#roleForm")
                    ,data=serializeForm($form);
                $.ajax({
                    dataType:"json",
                    url:  "<?=$this->baseurl.'save'?>",
                    data: {id:id,value:data},
                    type: 'POST',
                    success: function(res) {
                        if (res.errcode==0) {
                            loadRoleList();
                        } else {
                            $.showErr("更新角色"+res.errmsg);
                        }
                    }
                })
            }
        });
        $("#roleTab a[data-toggle='tab']").on("shown.bs.tab", function(e) {
            if(lastRoleId == -1) {
                $.showErr("加载角色关系","请先在左侧选择操作的角色");
                return;
            }
            if (e.target.getAttribute("href") == '#roleAclTab') {
                selectFirstTab = true;
                loadRoleAcl(lastRoleId);
            } else {
                selectFirstTab = false;
                loadRoleUser(lastRoleId);
            }
        });

        function loadRoleUser(selectedRoleId) {
            $.ajax({
                dataType:'json',
                url: "<?=$this->baseurl.'users'?>",
                data: {
                    roleId: selectedRoleId
                },
                type: 'POST',
                success: function (result) {
                    if (result.errcode==0) {
                        var renderedSelect = Mustache.render(selectedUsersTemplate, {userList: result.data.selected});
                        var renderedUnSelect = Mustache.render(unSelectedUsersTemplate, {userList: result.data.unselected});
                        $("#roleUserList").html(renderedSelect + renderedUnSelect);

                        if(!hasMultiSelect) {
                            $('select[name="roleUserList"]').bootstrapDualListbox({
                                showFilterInputs: false,
                                moveOnSelect: false,
                                infoText: false
                            });
                            hasMultiSelect = true;
                        } else {
                            $('select[name="roleUserList"]').bootstrapDualListbox('refresh', true);
                        }
                    } else {
                        $.showErr("加载角色关系,请先在左侧选择操作的角色"+res.errmsg);
                    }
                }
            });
        }

        $(".saveRoleUser").click(function (e) {
            e.preventDefault();
            if (lastRoleId == -1) {
                $.showErr("保存角色与用户的关系，请现在左侧选择需要操作的角色");
                return;
            }
            $.ajax({
                dataType:'json',
                url: "<?=$this->baseurl.'change_users'?>",
                data: {
                    roleId: lastRoleId,
                    userIds: $("#roleUserList").val() ? $("#roleUserList").val().join(",") : ''
                },
                type: 'POST',
                success: function (result) {
                    if (result.errcode==0) {
                        $.showSuccessTimeout("保存角色与用户的关系"+result.errmsg,3000,function(){
                        });
                    } else {
                        $.showErr("保存角色与用户的关系"+result.errmsg);
                    }
                }
            });
        });
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
</script>
