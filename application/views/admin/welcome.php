<?php $this->load->view('admin/header'); ?>
    <link href="<?=base_url('static/css/index.css')?>" rel="stylesheet" type="text/css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            仪表板
            <small>控制面板</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">控制面板</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="Top_Record">
                <div class="record_Top"><p>今日功德榜</p></div>
                <div class="topRec_List">
                    <dl>
                        <dd>用户昵称</dd>
                        <dd>捐赠项目</dd>
                        <dd>捐赠金额</dd>
                        <dd>时间</dd>
                    </dl>
                    <div class="maquee">
                        <ul id="contentList">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('admin/footer'); ?>
<script id="contentListTemplate" type="x-tmpl-mustache">
{{#contentList}}
<li><!--even -->
    <div>{{buyer_nick}}</div>
    <div>{{product_name}}</div>
    <div>{{order_total_price}}</div>
    <div>{{add_time}}</div>
</li>
{{/contentList}}
</script>
<script type="text/javascript">
    $(function(){
        var contentListTemplate = $('#contentListTemplate').html();
        Mustache.parse(contentListTemplate);
        loadContentList();
        function loadContentList() {
            var url = "<?=site_url('admin/main/lists')?>" ;
            $.ajax({
                type:'get',
                dataType:"json",
                url : url,
                success: function (res) {
                    if (res.errcode==0) {
                        if (res.data.total > 0){
                            var rendered = Mustache.render(contentListTemplate, {
                                contentList: res.data.list
                            });
                            $("#contentList").html(rendered);
                        } else {
                            $("#contentList").html('');
                        }
                    }
                }
            })
        }
        setInterval('autoScroll(".maquee")',3000);
    });
    function autoScroll(obj){
        $(obj).find("ul").animate({
            marginTop : "-39px"
        },500,function(){
            $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);
        })
    }
</script>