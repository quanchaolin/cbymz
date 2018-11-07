<?php $this->load->view('admin/header'); ?>
<!---parsley.css--->
<link href="<?=base_url('static/plugins/parsleyjs/src/parsley.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
            <small>维护权限模块和权限点关系</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl?>">权限模块管理</a></li>
            <li class="active">列表</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">权限模块列表</h3>
                        <a class="green" href="javascript:void(0);">
                            <i class="fa fa-plus-circle aclModule-add"></i>
                        </a>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding" id="aclModuleList">

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <input type="hidden" id="pageSize" value="10">
                        <h3 class="box-title">权限点列表</h3>
                        <a class="green" href="#">
                            <i class="fa fa-plus-circle acl-add"></i>
                        </a>
                        <div class="box-tools pull-right">
                            <div class="pull-right">
                                <div class="input-group input-group-sm pull-left" style="width: 150px;margin-left: 5px;">
                                    <input type="text" name="keywords" class="form-control pull-right" placeholder="权限名称..."  value="" >
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr role="row">
                                    <th>权限名称</th>
                                    <th>权限模块</th>
                                    <th>类型</th>
                                    <th>URL</th>
                                    <th>状态</th>
                                    <th>顺序</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody id="aclList"></tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('admin/footer'); ?>
<?php $this->load->view('admin/page'); ?>
<!-- Parsley -->
<script src="<?=base_url('static/plugins/parsleyjs/dist/parsley.min.js')?>"></script>
<script src="<?=base_url('static/plugins/parsleyjs/dist/i18n/zh_cn.js')?>"></script>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<div class="modal fade" id="dialog-aclModule-form">
    <div class="modal-dialog">
        <form class="table-responsive" id="aclModuleForm" data-parsley-validate>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">标题</h4>
                </div>
                <div class="modal-body">
                        <table class="table table-hover table-striped" role="grid">
                            <tr>
                                <td style="width: 80px;"><label for="parentModuleId">上级模块</label></td>
                                <td>
                                    <select class="form-control" id="parentModuleId" name="parent_id" data-placeholder="选择模块" style="width: 200px;"></select>
                                    <input type="hidden" name="id" id="aclModuleId"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="aclModuleName">名称</label></td>
                                <td><input type="text" name="name" id="aclModuleName" value="" class="form-control" data-parsley-required="true"></td>
                            </tr>
                            <tr>
                                <td><label for="aclModuleSeq">顺序</label></td>
                                <td><input type="text" name="seq" id="aclModuleSeq" value="1" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><label for="aclModuleStatus">状态</label></td>
                                <td>
                                    <select class="form-control" id="aclModuleStatus" name="status" data-placeholder="选择状态" style="width: 150px;">
                                        <option value="1">有效</option>
                                        <option value="2">无效</option>
                                        <option value="-1">删除</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="aclModuleRemark">备注</label></td>
                                <td><textarea name="remark" id="aclModuleRemark" class="form-control" rows="3" cols="25"></textarea></td>
                            </tr>
                        </table>
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
<div class="modal fade" id="dialog-acl-form">
    <div class="modal-dialog">
        <form class="table-responsive" id="aclForm" data-parsley-validate>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">标题</h4>
                </div>
                <div class="modal-body">
                        <table class="table table-hover table-striped" role="grid">
                            <tr>
                                <td style="width: 80px;"><label for="aclModuleSelectId">所属权限模块</label></td>
                                <td>
                                    <select class="form-control" id="aclModuleSelectId" name="acl_module_id" data-placeholder="选择权限模块" style="width: 200px;" data-parsley-required="true"></select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="aclName">名称</label></td>
                                <input type="hidden" name="id" id="aclId"/>
                                <td><input type="text" name="name" id="aclName" value="" class="form-control" data-parsley-required="true"></td>
                            </tr>
                            <tr>
                                <td><label for="aclType">类型</label></td>
                                <td>
                                    <select class="form-control" id="aclType" name="type" data-placeholder="类型" style="width: 150px;">
                                        <option value="1">菜单</option>
                                        <option value="2">按钮</option>
                                        <option value="3">其他</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="aclUrl">URL</label></td>
                                <td><input type="text" name="url" id="aclUrl" value="1" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><label for="aclStatus">状态</label></td>
                                <td>
                                    <select class="form-control" id="aclStatus" name="status" data-placeholder="选择状态" style="width: 150px;">
                                        <option value="1">有效</option>
                                        <option value="2">无效</option>
                                        <option value="-1">删除</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="aclSeq">顺序</label></td>
                                <td><input type="text" name="seq" id="aclSeq" value="" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><label for="aclRemark">备注</label></td>
                                <td><textarea name="remark" id="aclRemark" class="form-control" rows="3" cols="25"></textarea></td>
                            </tr>
                        </table>
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
<script id="aclModuleListTemplate" type="x-tmpl-mustache">
<ul class="dd-list ">
    {{#aclModuleList}}
        <li class="dd-item dd2-item aclModule-name {{displayClass}}" id="aclModule_{{id}}" href="javascript:void(0)" data-id="{{id}}">
            <div class="dd2-content" style="cursor:pointer;">
            {{name}}
            &nbsp;
            <a class="green {{#showDownAngle}}{{/showDownAngle}}" href="#" data-id="{{id}}" >
                <i class="fa fa-angle-double-down bigger-120 sub-aclModule"></i>
            </a>
            <span style="float:right;">
                <a class="green aclModule-edit" href="#" data-id="{{id}}" >
                    <i class="ace-icon fa fa-pencil bigger-100"></i>
                </a>
                &nbsp;
                <a class="red aclModule-delete" href="#" data-id="{{id}}" data-name="{{name}}">
                    <i class="fa fa-trash-o bigger-100"></i>
                </a>
            </span>
            </div>
        </li>
    {{/aclModuleList}}
</ul>
</script>

<script id="aclListTemplate" type="x-tmpl-mustache">
{{#aclList}}
<tr role="row" class="acl-name odd" data-id="{{id}}"><!--even -->
    <td><a href="#" class="acl-edit" data-id="{{id}}">{{name}}</a></td>
    <td>{{showAclModuleName}}</td>
    <td>{{showType}}</td>
    <td>{{url}}</td>
    <td>{{#bold}}{{showStatus}}{{/bold}}</td>
    <td>{{seq}}</td>
    <td>
        <div class="hidden-sm hidden-xs action-buttons">
            <a class="green acl-edit" href="#" data-id="{{id}}">
                <i class="ace-icon fa fa-pencil bigger-100"></i>
            </a>
        </div>
    </td>
</tr>
{{/aclList}}
</script>

<script type="text/javascript">
    $(function() {
        var aclModuleList; // 存储树形权限模块列表
        var aclModuleMap = {}; // 存储map格式权限模块信息
        var aclMap = {}; // 存储map格式的权限点信息
        var optionStr = "";
        var lastClickAclModuleId = -1;

        var aclModuleListTemplate = $('#aclModuleListTemplate').html();
        Mustache.parse(aclModuleListTemplate);
        var aclListTemplate = $('#aclListTemplate').html();
        Mustache.parse(aclListTemplate);

        loadAclModuleTree();

        function loadAclModuleTree() {
            $.ajax({
                type:'post',
                dataType:'json',
                url: "<?=$this->baseurl.'tree'?>",
                success : function (result) {
                    if(result.errcode==0) {
                        aclModuleList = result.data;
                        var rendered = Mustache.render(aclModuleListTemplate, {
                            aclModuleList: result.data,
                            "showDownAngle": function () {
                                return function (text, render) {
                                    return (this.aclModuleList && this.aclModuleList.length > 0) ? "" : "hidden";
                                }
                            },
                            "displayClass": function () {
                                return "";
                            }
                        });
                        $("#aclModuleList").html(rendered);
                        recursiveRenderAclModule(result.data);
                        bindAclModuleClick();
                    } else {
                        $.showErr('加载权限模块'+result.errmsg);
                    }
                }
            })
        }

        $(".aclModule-add").click(function () {
            optionStr = "<option value=\"0\">-</option>";
            recursiveRenderAclModuleSelect(aclModuleList, 1);
            $("#aclModuleForm")[0].reset();
            $("#aclModuleId").val('');
            $("#parentModuleId").html(optionStr);
            $('#dialog-aclModule-form').modal({
                backdrop: false
            });
        });
        $('#aclModuleForm').parsley().on('form:validated', function() {
            var ok = $('#aclModuleForm .parsley-error').length === 0;
            if(ok)
            {
                $('#dialog-aclModule-form').modal('hide');
                var id=$('#aclModuleId').val()
                    ,$form = $("#aclModuleForm")
                    ,data=serializeForm($form);
                $.ajax({
                    dataType:"json",
                    url:  "<?=$this->baseurl.'save'?>",
                    data: {id:id,value:data},
                    type: 'POST',
                    success: function(res) {
                        if (res.errcode==0) {
                            loadAclModuleTree();
                        } else {
                            $.showErr('更新权限模块'+res.errmsg);
                        }
                    }
                })
            }
        });
        $('#aclForm').parsley().on('form:validated', function() {
            var ok = $('#aclForm .parsley-error').length === 0;
            if(ok)
            {
                $('#dialog-acl-form').modal('hide');
                var id=$('#aclId').val()
                    ,$form = $("#aclForm")
                    ,data=serializeForm($form);
                $.ajax({
                    dataType:"json",
                    url:  "<?=$this->baseurl.'acl_save'?>",
                    data: {id:id,value:data},
                    type: 'POST',
                    success: function(res) {
                        if (res.errcode==0) {
                            loadAclList(lastClickAclModuleId);
                        } else {
                            $.showErr('更新权限模块'+res.errmsg);
                        }
                    }
                })
            }
        });

        function recursiveRenderAclModuleSelect(aclModuleList, level) {
            level = level | 0;
            if (aclModuleList && aclModuleList.length > 0) {
                $(aclModuleList).each(function (i, aclModule) {
                    aclModuleMap[aclModule.id] = aclModule;
                    var blank = "";
                    if (level > 1) {
                        for(var j = 3; j <= level; j++) {
                            blank += "..";
                        }
                        blank += "∟";
                    }
                    optionStr += Mustache.render("<option value='{{id}}'>{{name}}</option>", {id: aclModule.id, name: blank + aclModule.name});
                    if (aclModule.aclModuleList && aclModule.aclModuleList.length > 0) {
                        recursiveRenderAclModuleSelect(aclModule.aclModuleList, level + 1);
                    }
                });
            }
        }

        function recursiveRenderAclModule(aclModuleList) {
            if (aclModuleList && aclModuleList.length > 0) {
                $(aclModuleList).each(function (i, aclModule) {
                    aclModuleMap[aclModule.id] = aclModule;
                    if (aclModule.aclModuleList && aclModule.aclModuleList.length > 0) {
                        var rendered = Mustache.render(aclModuleListTemplate, {
                            aclModuleList: aclModule.aclModuleList,
                            "showDownAngle": function () {
                                return function (text, render) {
                                    return (this.aclModuleList && this.aclModuleList.length > 0) ? "" : "hidden";
                                }
                            },
                            "displayClass": function () {
                                return "hidden";
                            }
                        });
                        $("#aclModule_" + aclModule.id).append(rendered);
                        recursiveRenderAclModule(aclModule.aclModuleList);
                    }
                })
            }
        }

        function bindAclModuleClick() {
            $(".sub-aclModule").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).parent().parent().parent().children().children(".aclModule-name").toggleClass("hidden");
                if($(this).is(".fa-angle-double-down")) {
                    $(this).removeClass("fa-angle-double-down").addClass("fa-angle-double-up");
                } else{
                    $(this).removeClass("fa-angle-double-up").addClass("fa-angle-double-down");
                }
            });

            $(".aclModule-name").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var aclModuleId = $(this).attr("data-id");
                handleAclModuleSelected(aclModuleId);
            });

            $(".aclModule-delete").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                var aclModuleId = $(this).attr("data-id");
                var aclModuleName = $(this).attr("data-name");
                if (confirm("确定要删除权限模块[" + aclModuleName + "]吗?")) {
                    $.ajax({
                        type:'post',
                        dataType:'json',
                        url: "<?=$this->baseurl.'delete'?>",
                        data: {
                            id: aclModuleId
                        },
                        success: function (result) {
                            if (result.errcode==0) {
                                $.showSuccessTimeout("删除权限模块[" + aclModuleName + "]"+result.errmsg,3000,function(){
                                    loadAclModuleTree();
                                });
                            } else {
                                $.showErr("删除权限模块[" + aclModuleName + "]"+result.errmsg);
                            }
                        }
                    });
                }
            });

            $(".aclModule-edit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var aclModuleId = $(this).attr("data-id");
                optionStr = "<option value=\"0\">-</option>";
                recursiveRenderAclModuleSelect(aclModuleList, 1);
                $("#aclModuleForm")[0].reset();
                $("#parentModuleId").html(optionStr);
                var targetAclModule = aclModuleMap[aclModuleId];
                if (targetAclModule) {
                    $("#aclModuleId").val(targetAclModule.id);
                    $("#parentModuleId").val(targetAclModule.pid);
                    $("#aclModuleName").val(targetAclModule.name);
                    $("#aclModuleSeq").val(targetAclModule.seq);
                    $("#aclModuleRemark").val(targetAclModule.remark);
                    $("#aclModuleStatus").val(targetAclModule.status);
                }
                $('#dialog-aclModule-form').modal({
                    backdrop: false
                });
            });
        }

        function handleAclModuleSelected(aclModuleId) {
            if (lastClickAclModuleId != -1) {
                var lastAclModule = $("#aclModule_" + lastClickAclModuleId + " .dd2-content:first");
                lastAclModule.removeClass("btn-yellow");
                lastAclModule.removeClass("no-hover");
            }
            var currentAclModule = $("#aclModule_" + aclModuleId + " .dd2-content:first");
            currentAclModule.addClass("btn-yellow");
            currentAclModule.addClass("no-hover");
            lastClickAclModuleId = aclModuleId;
            loadAclList(aclModuleId);
        }

        function loadAclList(aclModuleId) {
            var pageSize = $("#pageSize").val();
            var url = "<?=$this->baseurl.'acl?aclModuleId='?>" + aclModuleId;
            var pageNo = $("#aclPage .pageNo").val() || 1;
            $.ajax({
                type:'post',
                dataType:'json',
                url : url,
                data: {
                    pageSize: pageSize,
                    pageNo: pageNo
                },
                success: function (result) {
                    renderAclListAndPage(result, url);
                }
            })
        }

        function renderAclListAndPage(result, url) {
            if(result.errcode==0) {
                if (result.data.total > 0){
                    var rendered = Mustache.render(aclListTemplate, {
                        aclList: result.data.data,

                        "showStatus": function() {
                            return this.status == 1 ? "有效": "无效";
                        },
                        "showType": function() {
                            return this.type == 1 ? "菜单" : (this.type == 2 ? "按钮" : "其他");
                        },
                        "bold": function() {
                            return function(text, render) {
                                var status = render(text);
                                if (status == '有效') {
                                    return "<span class='label label-sm label-success'>有效</span>";
                                } else if(status == '无效') {
                                    return "<span class='label label-sm label-warning'>无效</span>";
                                } else {
                                    return "<span class='label'>删除</span>";
                                }
                            }
                        }
                    });
                    $("#aclList").html(rendered);
                    bindAclClick();
                    $.each(result.data.data, function(i, acl) {
                        aclMap[acl.id] = acl;
                    })
                } else {
                    $("#aclList").html('');
                }
                var pageSize = $("#pageSize").val();
                var pageNo = $("#aclPage .pageNo").val() || 1;
                renderPage(url, result.data.total, pageNo, pageSize, result.data.total > 0 ? result.data.data.length : 0, "aclPage", renderAclListAndPage);
            } else {
                $.showErr('获取权限点列表'+result.errmsg);
            }
        }

        function bindAclClick() {
            $(".acl-role").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                var aclId = $(this).attr("data-id");
                $.ajax({
                    url: "/sys/acl/acls.json",
                    data: {
                        aclId: aclId
                    },
                    success: function(result) {
                        if (result.ret) {
                            console.log(result)
                        } else {
                            $.showErr('获取权限点分配的用户和角色'+result.errmsg);
                        }
                    }
                })
            });
            $(".acl-edit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var aclId = $(this).attr("data-id");
                optionStr = "";
                recursiveRenderAclModuleSelect(aclModuleList, 1);
                $("#aclForm")[0].reset();
                $("#aclModuleSelectId").html(optionStr);
                var targetAcl = aclMap[aclId];
                if (targetAcl) {
                    $("#aclId").val(aclId);
                    $("#aclModuleSelectId").val(targetAcl.acl_module_id);
                    $("#aclStatus").val(targetAcl.status);
                    $("#aclType").val(targetAcl.type);
                    $("#aclName").val(targetAcl.name);
                    $("#aclUrl").val(targetAcl.url);
                    $("#aclSeq").val(targetAcl.seq);
                    $("#aclRemark").val(targetAcl.remark);
                }
                $('#dialog-acl-form').modal({
                    backdrop: false
                });
            })
        }
        $(".acl-add").click(function() {
            $("#aclId").val('');
            optionStr = "";
            recursiveRenderAclModuleSelect(aclModuleList, 1);
            $("#aclForm")[0].reset();
            $("#aclModuleSelectId").html(optionStr);
            $('#dialog-acl-form').modal({
                backdrop: false
            });
        })
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
</script>
