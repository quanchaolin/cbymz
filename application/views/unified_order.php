<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>慈悲圆满洲</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?=base_url('static/plugins/SUI/css/sm.css')?>">
    <style type="text/css">
        .modal-text {
            max-height: 255px;
            overflow: auto;
        }
    </style>
</head>
<body>
    <div class="page-group">
        <!-- 单个page ,第一个.page默认被展示-->
        <div class="page" id="page-home">

        </div>
    </div>
<script type='text/javascript' src='<?=base_url('static/plugins/SUI/js/zepto.js')?>' charset='utf-8'></script>
<script type='text/javascript' src='<?=base_url('static/plugins/SUI/js/sm.js')?>' charset='utf-8'></script>
<script type="text/javascript">
    $(function () {
        'use strict';
        callpay();
        /*$(document).on("pageInit", "#page-home", function(e, id, page) {
                $.modal({
                    title:  '支付提醒',
                    text: '特别声明：由于寺院为非营利性机构，《慈悲圆满洲》公众号因涉及善款支付需要，在搭建平台时借用了“昆明市五华区倾情时尚时装店”的义工师兄的营业执照等相关具有法律效力的证明文件才得以顺利完成。现今平台上线运行，更是得到师兄及善信们的大力支持，非常感谢大家！基于支付系统的设置，您通过微信支付相关善款时收款方会显示为义工师兄为平台搭建所提供的证件及店铺名称等信息，但善款由义工师兄们直接交给我本人转与寺院执行，寺院将执行情况、善款去向提供给义工师兄们，并定期在公众号进行公布！一切如法圆满！请师兄、善信们知悉。－－桑格堪布仁波切',
                    buttons: [
                        {
                            text: '好的，我知道了',
                            bold: true,
                            onClick: function() {
                                callpay();
                            }
                        }
                    ]
                });
        });*/
        $.init();
    });
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters; ?>,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                        window.location.replace("<?=site_url('back_paper/index?trans_id='.$trans_id)?>");
                    }else if (res.err_msg == "get_brand_wcpay_request:cancel") {
                        $.alert("已取消微信支付!");
                        window.history.back(-1);
                    }
                }
            );
        }
        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
</script>
</body>
</html>