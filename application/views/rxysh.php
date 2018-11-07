<!DOCTYPE html>
<html lang="Zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title><?=$value['name']?></title>
    <link rel="stylesheet" href="<?=base_url('static/pay/css/mystyle.css?1')?>">
</head>
<body>
<div class="index">
    <input type="hidden" name="id" value="<?=$value['id']?>"/>
    <input type="hidden" name="openid" value="<?=$openid?>"/>
    <div class="hongbao">
        <h3><img src="<?=base_url('static/pay/images/title1.png')?>"/></h3>
        <ul>
            <li class="hongbao_a"><div class="i_tips"></div><img src="<?=base_url('static/pay/images/hongbao_a.png')?>"/><p>供灯会供</p></li>
            <li class="hongbao_b"><div class="i_tips"></div><img src="<?=base_url('static/pay/images/hongbao_b.png')?>"/><p>放生护生</p></li>
            <li class="hongbao_c"><div class="i_tips"></div><img src="<?=base_url('static/pay/images/hongbao_c.png')?>"/><p>供养僧人</p></li>
            <li class="hongbao_d"><div class="i_tips"></div><img src="<?=base_url('static/pay/images/hongbao_d.png')?>"/><p>助印经书</p></li>
        </ul>
        <div class="clear"></div>

    </div>

    <div class="popup-box">
        <div class="popup-content" id="hongbao_a_con">
            <h3><a class="close"></a>供灯会供</h3>
            <div class="i_box"><a href="javascript:;" class="J_minus">-</a><input type="text" value="0" class="J_input" /><a href="javascript:;" class="J_add">+</a></div>
            <p><input type="button" class="btnok" value="确 定"></p>
        </div>
        <div class="popup-content" id="hongbao_b_con">
            <h3><a class="close"></a>放生护生</h3>
            <div class="i_box"><a href="javascript:;" class="J_minus">-</a><input type="text" value="0" class="J_input" /><a href="javascript:;" class="J_add">+</a></div>
            <p><input type="button" class="btnok" value="确 定"></p>
        </div>
        <div class="popup-content" id="hongbao_c_con">
            <h3><a class="close"></a>供养僧人</h3>
            <div class="i_box"><a href="javascript:;" class="J_minus">-</a><input type="text" value="0" class="J_input" /><a href="javascript:;" class="J_add">+</a></div>
            <p><input type="button" class="btnok" value="确 定"></p>
        </div>
        <div class="popup-content" id="hongbao_d_con">
            <h3><a class="close"></a>助印经书</h3>
            <div class="i_box"><a href="javascript:;" class="J_minus">-</a><input type="text" value="0" class="J_input" /><a href="javascript:;" class="J_add">+</a></div>
            <p><input type="button" class="btnok" value="确 定"></p>
        </div>
    </div>
    <div class="popup-box2">
        <div class="popup-content">
            <h3><a class="close"></a>提示</h3>
            <p class="popup-text">红包金额不能为0元，请重新选择！</p>
        </div>
    </div>
    <div class="rxys_text">
        <p>每天布施一元钱，祈愿365天拥有365个美丽妙曼圆满的发心，</p>
        <p>每天发心一点点，才能时刻提醒自己行善的初心。</p>
        <p>我们的口号是“一善念起，百念花开”</p>
        <p>每天都可以随喜一元钱，</p>
        <p>美好的一天从美好的发心开始，快来加入“日行一善”功德海吧！</p>
        <p>勿以善小而不为，您也可以改变世界！</p>
        <p><strong>随喜进入“日行一善”，您所做的一切功德善业均会作如法圆满回向！</strong></p>
    </div>
<div class="list_box">
    <h3><img src="<?=base_url('static/pay/images/title2.png')?>"/></h3>
    <div class="list">
        <div class="list_lh">
            <ul>
                <?php foreach($list as $item):?>
                    <li><p>·<span><?=$item['buyer_nick']?></span><?=$item['add_time']?>捐款<strong><?=$item['order_total_price']?>元</strong></p></li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
    <div class="zfbox"><div class="all_text">共计：<span class="all_hb"></span></div><input type="button" class="btn" value="去支付"></div>
<span id="musicControl">
        <a id="mc_play" class="stop" onClick="play_music();">
            <audio id="musicfx" loop>
                <source src="<?=base_url('static/pay/mp3/mp3.mp3')?>" type="audio/mpeg">
            </audio>
        </a>
 </span>
</div>
<div class="mui-cover">
    <header>
        <h1>您的心愿单</h1>
        <span class="mui-cover-close">×</span>
    </header>
    <div class="list-block">
        <ul>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-input">
                            <input type="text" id="name" value="<?=$order['receiver_name']?>" placeholder="功德主名字(可选填)">
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-input">
                            <input type="tel" class="" id="tel" value="<?=$order['receiver_mobile']?>" placeholder="联系电话(可选填)">
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="mui-flex">
        <input type="button" class="ok cell" value="确定"/>
    </div>
</div>
<div class="cover-decision"></div>
<!-- 引入js文件 -->
<script src="<?=base_url('static/pay/js/jquery-2.1.4.min.js')?>"></script>
<script src="<?=base_url('static/pay/js/myscript.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/pay/js/jquery.iVaryVal.js')?>"></script>
<script type="text/javascript" src="<?=base_url('static/pay/js/jquery.myScroll.js')?>"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>

    //调用
    $( function() {
        $('.list_lh li:even').addClass('lieven');
        $('.i_box').iVaryVal({},function(value,index){
            $('.i_tips').html('你点击的表单索引是：'+index+'；改变后的表单值是：'+value);
        });
        $("div.list_lh").myScroll({
            speed:40, //数值越大，速度越慢
            rowHeight:80 //li的高度
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".mui-cover-close").on('click',function(){
            $('.cover-decision').removeClass('show');
            $('.mui-cover').removeClass('show');
        });
        $('#mc_play audio').get(0).volume=0.1;
        $(".hongbao_a").on('click',function () {
            $('html').addClass('not-allow-scroll');
            $('.popup-box').show();
            $('#hongbao_a_con').show();
            $(this).addClass('on');
            $('.zfbox').show();
        });


        $(".hongbao_b").on('click',function () {
            $('html').addClass('not-allow-scroll');
            $('.popup-box').show();
            $('#hongbao_b_con').show();
            $(this).addClass('on');
            $('.zfbox').show();
        });


        $(".hongbao_c").on('click',function () {

            $('html').addClass('not-allow-scroll');
            $('.popup-box').show();
            $('#hongbao_c_con').show();
            $(this).addClass('on');
            $('.zfbox').show();
        });


        $(".hongbao_d").on('click',function () {

            $('html').addClass('not-allow-scroll');
            $('.popup-box').show();
            $('#hongbao_d_con').show();
            $(this).addClass('on');
            $('.zfbox').show();
        });



        $(".close").on('click',function () {
            $('html').removeClass('not-allow-scroll');
            $('.popup-box').hide();
            $('.popup-box2').hide();
            $('.popup-content').hide();

            var hd_value_a=$("#hongbao_a_con .J_input").val();
            var hd_value_b=$("#hongbao_b_con .J_input").val();
            var hd_value_c=$("#hongbao_c_con .J_input").val();
            var hd_value_d=$("#hongbao_d_con .J_input").val();


            $('.hongbao_a .i_tips').html(hd_value_a+'元');
            $('.hongbao_b .i_tips').html(hd_value_b+'元');
            $('.hongbao_c .i_tips').html(hd_value_c+'元');
            $('.hongbao_d .i_tips').html(hd_value_d+'元');
            var all_hb=parseInt(hd_value_a)+parseInt(hd_value_b)+parseInt(hd_value_c)+parseInt(hd_value_d);
            $('.all_hb').html(all_hb+'元');
        });

        $(".btnok").on('click',function () {
            $('html').removeClass('not-allow-scroll');
            $('.popup-box').hide();
            $('.popup-content').hide();
            $('.popup-box2').hide();
            var hd_value_a=$("#hongbao_a_con .J_input").val();
            var hd_value_b=$("#hongbao_b_con .J_input").val();
            var hd_value_c=$("#hongbao_c_con .J_input").val();
            var hd_value_d=$("#hongbao_d_con .J_input").val();


            $('.hongbao_a .i_tips').html(hd_value_a+'元');
            $('.hongbao_b .i_tips').html(hd_value_b+'元');
            $('.hongbao_c .i_tips').html(hd_value_c+'元');
            $('.hongbao_d .i_tips').html(hd_value_d+'元');
            var all_hb=parseInt(hd_value_a)+parseInt(hd_value_b)+parseInt(hd_value_c)+parseInt(hd_value_d);
            $('.all_hb').html(all_hb+'元');
        });

        $(".J_add").on('click',function () {
            var hd_value_a=$("#hongbao_a_con .J_input").val();
            var hd_value_b=$("#hongbao_b_con .J_input").val();
            var hd_value_c=$("#hongbao_c_con .J_input").val();
            var hd_value_d=$("#hongbao_d_con .J_input").val();


            $('.hongbao_a .i_tips').html(hd_value_a+'元');
            $('.hongbao_b .i_tips').html(hd_value_b+'元');
            $('.hongbao_c .i_tips').html(hd_value_c+'元');
            $('.hongbao_d .i_tips').html(hd_value_d+'元');
            var all_hb=parseInt(hd_value_a)+parseInt(hd_value_b)+parseInt(hd_value_c)+parseInt(hd_value_d);
            $('.all_hb').html(all_hb+'元');
        });

        $(".J_minus").on('click',function () {
            var hd_value_a=$("#hongbao_a_con .J_input").val();
            var hd_value_b=$("#hongbao_b_con .J_input").val();
            var hd_value_c=$("#hongbao_c_con .J_input").val();
            var hd_value_d=$("#hongbao_d_con .J_input").val();

            $('.hongbao_a .i_tips').html(hd_value_a+'元');
            $('.hongbao_b .i_tips').html(hd_value_b+'元');
            $('.hongbao_c .i_tips').html(hd_value_c+'元');
            $('.hongbao_d .i_tips').html(hd_value_d+'元');
            var all_hb=parseInt(hd_value_a)+parseInt(hd_value_b)+parseInt(hd_value_c)+parseInt(hd_value_d);
            $('.all_hb').html(all_hb+'元');
        });

        $(".btn").on('click',function () {

            var hd_value_a=$("#hongbao_a_con .J_input").val();
            var hd_value_b=$("#hongbao_b_con .J_input").val();
            var hd_value_c=$("#hongbao_c_con .J_input").val();
            var hd_value_d=$("#hongbao_d_con .J_input").val();


            $('.hongbao_a .i_tips').html(hd_value_a+'元');
            $('.hongbao_b .i_tips').html(hd_value_b+'元');
            $('.hongbao_c .i_tips').html(hd_value_c+'元');
            $('.hongbao_d .i_tips').html(hd_value_d+'元');
            var all_hb=parseInt(hd_value_a)+parseInt(hd_value_b)+parseInt(hd_value_c)+parseInt(hd_value_d);
            if(all_hb==0){
                $('.popup-box2').show();
                $('.popup-content').show();
            }
            else
            {
                $('.cover-decision').addClass('show');
                $('.mui-cover').addClass('show');
                return false;
            }
        });
        $(".ok").on('click',function(){
            var id=$("input[name='id']").val()
                ,hd_value_a=$("#hongbao_a_con .J_input").val()
                ,hd_value_b=$("#hongbao_b_con .J_input").val()
                ,hd_value_c=$("#hongbao_c_con .J_input").val()
                ,hd_value_d=$("#hongbao_d_con .J_input").val()
                ,openid=$("input[name='openid']").val()
                ,all_hb=parseInt(hd_value_a)+parseInt(hd_value_b)+parseInt(hd_value_c)+parseInt(hd_value_d)
            ,name=$('#name').val()
            ,tel=$('#tel').val();
            var _data={
                hd_value_a:hd_value_a,
                hd_value_b:hd_value_b,
                hd_value_c:hd_value_c,
                hd_value_d:hd_value_d,
                openid:openid,
                all_hb:all_hb,
                receiver_name:name,
                receiver_mobile:tel
            };
            $.ajax({
                type: "POST",
                url: '<?=site_url('order/rxysh_order')?>' ,
                data: {id:id,value:_data},
                cache:false,
                dataType:"json",
                beforeSend:function(){
                    $('.ok').val('处理中...').attr('disabled','disabled');
                },
                //  async:false,
                success: function(res){
                    if(res.errcode!=0){
                        alert(res.errmsg);
                        $('.ok').val('确定').removeAttr('disabled');
                        return false;
                    }
                    else{
                        $('.hongbao_a .i_tips').html('');
                        $('.hongbao_b .i_tips').html('');
                        $('.hongbao_c .i_tips').html('');
                        $('.hongbao_d .i_tips').html('');

                        $("#hongbao_a_con .J_input").val(0);
                        $("#hongbao_b_con .J_input").val(0);
                        $("#hongbao_c_con .J_input").val(0);
                        $("#hongbao_d_con .J_input").val(0);

                        $('.all_hb').html('0元');
                        var trans_id=res.data.trans_id;
                        var redirect_url=res.data.redirect_url+'?trans_id='+trans_id;
                        window.location.href=redirect_url;
                    }
                },
                error:function(){
                    alert("服务器繁忙，请稍后...");
                    $('.ok').val('确定').removeAttr('disabled');
                    return false;
                }
            });
        });
    });
    wx.config({
        debug: false,
        appId: '<?=$signPackage['appId']?>',
        timestamp: <?=$signPackage['timestamp']?>,
        nonceStr: '<?=$signPackage['nonceStr']?>',
        signature: '<?=$signPackage['signature']?>',
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareQZone'
        ]
    });
    wx.ready(function(){
        //获取“分享到朋友圈”按钮点击状态及自定义分享内容接口
        wx.onMenuShareTimeline({
            title: '<?=$news['Title']?>', // 分享标题
            link: '<?=$news['Url']?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '<?=$news['PicUrl']?>' // 分享图标
        });
        //获取“分享给朋友”按钮点击状态及自定义分享内容接口
        wx.onMenuShareAppMessage({
            title: '<?=$news['Title']?>', // 分享标题
            desc: '<?=$news['Description']?>', // 分享描述
            link: '<?=$news['Url']?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '<?=$news['PicUrl']?>', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '' // 如果type是music或video，则要提供数据链接，默认为空
        });
        //获取“分享到QQ”按钮点击状态及自定义分享内容接口
        wx.onMenuShareQQ({
            title: '<?=$news['Title']?>', // 分享标题
            desc: '<?=$news['Description']?>', // 分享描述
            link: '<?=$news['Url']?>', // 分享链接
            imgUrl: '<?=$news['PicUrl']?>' // 分享图标
        });
        //获取“分享到QQ空间”按钮点击状态及自定义分享内容接口
        wx.onMenuShareQZone({
            title: '<?=$news['Title']?>', // 分享标题
            desc: '<?=$news['Description']?>', // 分享描述
            link: '<?=$news['Url']?>', // 分享链接
            imgUrl: '<?=$news['PicUrl']?>' // 分享图标
        });
    });
</script>
</body>
</html>