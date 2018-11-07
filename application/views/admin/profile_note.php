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
            <li class="active">笔记</li>
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
                        <h3 class="box-title">笔记</h3>
                        <a class="green" href="#">
                            <i class="fa fa-plus-circle note-add"></i>
                        </a>
                    </div>
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
                                        <input type="text" name="keywords" class="form-control pull-right" placeholder="标题..."  value="" >
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
                        <div class="box-group" id="noteList">

                        </div>
                    </div>
                    <div class="box-footer clearfix" id="userPage">

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
<?php $this->load->view('admin/page'); ?>
<!-- Parsley -->
<script src="<?=base_url('vendor/parsleyjs/dist/parsley.min.js')?>"></script>
<script src="<?=base_url('vendor/parsleyjs/dist/i18n/zh_cn.js')?>"></script>
<!--custom.js-->
<script type="application/javascript" src="<?=base_url('static/js/custom.js')?>"></script>
<div class="modal fade" id="dialog-note-form">
    <div class="modal-dialog">
        <form method="post" action="#" id="noteForm" data-parsley-validate>
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
                                <td style="width: 80px;"><label for="noteTitle">标题</label></td>
                                <input type="hidden" name="id" id="noteId"/>
                                <td><input type="text" name="title" id="noteTitle" value="" class="form-control" data-parsley-required="true" /></td>
                            </tr>
                            <tr>
                                <td><label for="noteDescription">笔记内容</label></td>
                                <td><textarea name="description" id="noteDescription" class="form-control" rows="5" cols="25"></textarea></td>
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
<script id="noteListTemplate" type="x-tmpl-mustache">
{{#noteList}}
    <div class="panel box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{id}}" aria-expanded="false" class="collapsed">
                    {{title}}
                </a>
            </h4>
        </div>
        <div id="collapseOne{{id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
            <div class="box-body">
                {{description}}
            </div>
        </div>
    </div>
{{/noteList}}
</script>
<script>
    $(function(){
        var noteMap = {}; // 存储map格式的权限点信息
        var noteListTemplate = $('#noteListTemplate').html();
        Mustache.parse(noteListTemplate);
        loadNoteList();
        $(".submit").click(function(){
            loadNoteList();
        });
        function loadNoteList() {
            var pageSize = $("#pageSize").val();
            var url = "<?=site_url('admin/note/lists')?>";
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
                    renderNoteListAndPage(result, url);
                }
            })
        }
        function renderNoteListAndPage(result, url) {
            if (result.errcode==0) {
                if (result.data.total > 0){
                    var rendered = Mustache.render(noteListTemplate, {
                        noteList: result.data.data
                    });
                    $("#noteList").html(rendered);
                    bindNoteClick();
                    $.each(result.data.data, function(i, note) {
                        noteMap[note.id] = note;
                    })
                } else {
                    $("#noteList").html('');
                }
                var pageSize = $("#pageSize").val();
                var pageNo = parseInt($("#userPage .pageNo").val()) || 1;
                renderPage(url, result.data.total, pageNo, pageSize, result.data.total > 0 ? result.data.data.length : 0, "userPage", renderNoteListAndPage);
            } else {
                $.showErr(result.errmsg);
            }
        }
        $('#noteForm').parsley().on('form:validated', function() {
            var ok = $('.parsley-error').length === 0;
            if(ok)
            {
                var id=$('#noteId').val()
                    ,$form = $("#noteForm")
                    ,data=serializeForm($form);
                $.ajax({
                    type: 'POST',
                    dataType:"json",
                    url:  "<?=site_url('admin/note/save')?>",
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
        $(".note-add").click(function() {
            $("#noteForm")[0].reset();
            $('#dialog-note-form').modal({
                backdrop: false
            });
        });

        function bindNoteClick(){
            $(".note-edit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var noteId = $(this).attr("data-id");
                $("#noteForm")[0].reset();
                var targetUser = noteMap[noteId];
                if (targetUser) {
                    $("#noteTitle").val(targetUser.title);
                    $("#noteDescription").val(targetUser.description);
                }
                $('#dialog-edu-form').modal({
                    backdrop: false
                });
            });
        }
    });
    Parsley.on('form:submit', function() {
        return false; // Don't submit form for this demo
    });
</script>