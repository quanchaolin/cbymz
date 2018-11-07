<?php $this->load->view('admin/header'); ?>
<!---parsley.css--->
<link href="<?=base_url('vendor/parsleyjs/src/parsley.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="crop-avatar">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl.'index'?>">个人中心</a></li>
            <li class="active">教育背景</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php $this->load->view('admin/profile_left'); ?>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">教育背景</h3>
                        <a class="green" href="#">
                            <i class="fa fa-plus-circle edu-add"></i>
                        </a>
                    </div>
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>学校类型</th>
                                    <th>学校名称</th>
                                    <th>入学年份</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody id="eduList"></tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('admin/footer'); ?>
<!-- Parsley -->
<script src="<?=base_url('vendor/parsleyjs/dist/parsley.min.js')?>"></script>
<script src="<?=base_url('vendor/parsleyjs/dist/i18n/zh_cn.js')?>"></script>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<div class="modal fade" id="dialog-edu-form">
    <div class="modal-dialog">
        <form method="post" action="#" id="eduForm" data-parsley-validate>
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
                                <td style="width: 80px;"><label for="schoolTypeSelectId">学校类型</label></td>
                                <td>
                                    <select id="schoolTypeSelectId" class="form-control" name="school_type" data-placeholder="选择学校类型" style="width: 200px;" data-parsley-required="true"></select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="userName">学校名称</label></td>
                                <input type="hidden" name="id" id="eduId"/>
                                <td><input type="text" name="school_name" id="schoolName" value="" class="form-control" data-parsley-required="true" /></td>
                            </tr>
                            <tr>
                                <td><label for="schoolYear">入学年份</label></td>
                                <td><input type="text" name="school_year" id="schoolYear" value="" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><label for="userStatus">状态</label></td>
                                <td>
                                    <select class="form-control" id="eduStatus" name="status" data-placeholder="选择状态" style="width: 150px;">
                                        <option value="1">有效</option>
                                        <option value="0">无效</option>
                                        <option value="-1">删除</option>
                                    </select>
                                </td>
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
<script id="eduListTemplate" type="x-tmpl-mustache">
{{#eduList}}
<tr role="row" class="acl-name odd" data-id="{{id}}"><!--even -->
    <td>{{showType}}</td>
    <td><a href="#" class="edu-edit" data-id="{{id}}">{{school_name}}</a></td>
    <td>{{school_year}}</td>
    <td>{{#bold}}{{showStatus}}{{/bold}}</td> <!-- 此处套用函数对status做特殊处理 -->
    <td>
        <div class="hidden-sm hidden-xs action-buttons">
            <a class="green edu-edit" href="#" data-id="{{id}}">
                <i class="fa fa-pencil bigger-100"></i>
            </a>
        </div>
    </td>
</tr>
{{/eduList}}
</script>
<script>
    $(function(){
        var schoolTypeList=<?=$school_type?>;
        var eduMap = {}; // 存储map格式的权限点信息
        var optionStr = "";
        var eduListTemplate = $('#eduListTemplate').html();
        Mustache.parse(eduListTemplate);
        loadEduList();
        $('#eduForm').parsley().on('form:validated', function() {
            var ok = $('.parsley-error').length === 0;
            if(ok)
            {
                var id=$('#eduId').val()
                    ,$form = $("#eduForm")
                    ,data=serializeForm($form);
                $.ajax({
                    type: 'POST',
                    dataType:"json",
                    url:  "<?=site_url('admin/education/save')?>",
                    data: {id:id,value:data},
                    success: function(res) {
                        if (res.errcode==0) {
                            $.showSuccessTimeout(res.errmsg,3000,function(){
                                window.location.reload();
                            });
                        } else {
                            $.showErr(res.errmsg);
                        }
                    }
                })
            }
        });
        $(".edu-add").click(function() {
            $('#eduId').val('');
            optionStr = "";
            recursiveRenderTypeSelect();
            $("#eduForm")[0].reset();
            $("#schoolTypeSelectId").html(optionStr);
            $('#dialog-edu-form').modal({
                backdrop: false
            });
        });
        function loadEduList() {
            var url = "<?=site_url('admin/education/lists')?>";
            $.ajax({
                type:'post',
                dataType:'json',
                url : url,
                success: function (result) {
                    renderEduList(result, url);
                }
            })
        }
        function renderEduList(result, url) {
            if(result.errcode==0) {
                if (result.data.total > 0){
                    var rendered = Mustache.render(eduListTemplate, {
                        eduList: result.data.data,
                        "showType":function(){
                            var type=this.school_type;
                            return schoolTypeList[type];
                        },
                        "showStatus": function() {
                            return this.status == 1 ? '有效' : (this.status == 0 ? '无效' : '删除');
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
                    $("#eduList").html(rendered);
                    bindEduClick();
                    $.each(result.data.data, function(i, edu) {
                        eduMap[edu.id] = edu;
                    })
                } else {
                    $("#eduList").html('');
                }
            } else {
                $.showErr(result.errmsg);
            }
        }
        function bindEduClick(){
            $(".edu-edit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var eduId = $(this).attr("data-id");
                optionStr = "";
                recursiveRenderTypeSelect(eduId);
                $("#eduForm")[0].reset();
                $("#schoolTypeSelectId").html(optionStr);
                var targetUser = eduMap[eduId];
                if (targetUser) {
                    $("#schoolName").val(targetUser.school_name);
                    $("#schoolYear").val(targetUser.school_year);
                    $("#eduStatus").val(targetUser.status);
                    $("#eduId").val(targetUser.id);
                }
                $('#dialog-edu-form').modal({
                    backdrop: false
                });
            });
        }
        function recursiveRenderTypeSelect(eduId){
            optionStr+='<option value='+""+'>请选择</option>';
            eduId = eduId | 0;
            var targetEdu = eduMap[eduId];
            if (schoolTypeList) {
                for(var i in schoolTypeList) {
                    var selected='';
                    if (targetEdu && targetEdu.school_type==i) {
                        selected='selected';
                    }
                    optionStr += Mustache.render("<option {{selected}} value='{{key}}'>{{val}}</option>", {selected:selected,key:i, val:  schoolTypeList[i]});
                }

            }
        }
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
</script>