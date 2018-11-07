<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong><?=get_admin_config('site_copyright')?><a href="#"><?=get_admin_config('site_name')?></a>.</strong> 版权所有.
</footer>
<?php $this->load->view('admin/right_sidebar.php')?>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?=base_url('static/plugins/jquery/dist/jquery.min.js')?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('static/plugins/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<!-- PACE -->
<script src="<?=base_url('static/plugins/pace/pace.min.js')?>"></script>
<!-- Select2 -->
<script src="<?=base_url('static/plugins/select2/dist/js/select2.full.min.js')?>"></script>
<!-- Slimscroll -->
<script src="<?=base_url('static/plugins/jquery-slimscroll/jquery.slimscroll.min.js')?>"></script>
<!-- FastClick -->
<script src="<?=base_url('static/plugins/fastclick/lib/fastclick.js')?>"></script>
<!-- bootstrap-dialog -->
<script src="<?=base_url('static/plugins/bootstrap-dialog/dist/js/bootstrap-dialog.min.js')?>"></script>
<script type="application/javascript" src="<?=base_url('static/js/dialog.js')?>"></script>


<script src="<?=base_url('static/plugins/mustache.js/mustache.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('static/plugins/AdminLTE/js/adminlte.min.js')?>"></script>
<!-- iCheck 1.0.1 -->
<script src="<?=base_url('static/plugins/iCheck/icheck.min.js')?>"></script>
<!-- Parsley -->
<script src="<?=base_url('static/plugins/parsleyjs/dist/parsley.min.js')?>"></script>
<script src="<?=base_url('static/plugins/parsleyjs/dist/i18n/zh_cn.js')?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url('static/plugins/AdminLTE/js/demo.js')?>"></script>
<script>
    //Initialize Select2 Elements
    $('.select2').select2();
    $(document).ajaxStart(function () {
        Pace.restart()
    });
    $(function(){
        var messageTemplate = $("#messageTemplate").html();
        Mustache.parse(messageTemplate);
        loadMessageList();
        function loadMessageList() {
            $.ajax({
                type:'post',
                dataType:'json',
                url: "<?=site_url('admin/message/ajax_list/')?>",
                success: function (res) {
                    if (res.errcode==0) {
                        var data=res.data;
                        var rendered = Mustache.render(messageTemplate, {
                            messageList: data.list,
                            "showUrl":function(){
                                return '<?=site_url('admin/message/detail?id=')?>'+this.id
                            }
                        });
                        $(".message-count").html(data.count);
                        $("#nav-message").html(rendered);
                    }
                }
            });
        }
    });
</script>
<?php $this->load->view('admin/common_menu')?>
</body>
</html>