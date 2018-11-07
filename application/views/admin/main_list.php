<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>慈悲院满洲-主页</title>
    <link href="<?=base_url('static/css/index.css')?>" rel="stylesheet" type="text/css">
    <script src="<?=base_url('static/pay/js/jquery-2.1.4.min.js')?>"></script>
</head>
<body>
<!-- -------------摇奖排行榜---------------  -->
<div class="Top_Record">
    <div class="record_Top"><p>今日功德榜</p></div>
    <div class="topRec_List">
        <dl>
            <dd>用户昵称</dd>
            <dd>捐赠金额</dd>
            <dd>捐赠项目</dd>
            <dd>时间</dd>
        </dl>
        <div class="maquee">
            <ul>
                <?php foreach($list as $item):?>
                    <li>
                        <div><?=$item['buyer_nick']?></div>
                        <div><?=$item['order_total_price']?></div>
                        <div><?=$item['product_name']?></div>
                        <div><?=$item['add_time']?></div>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    function autoScroll(obj){
        $(obj).find("ul").animate({
            marginTop : "-39px"
        },500,function(){
            $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);
        })
    }
    $(function(){
        setInterval('autoScroll(".maquee")',3000);
    })
</script>
</body>
</html>
