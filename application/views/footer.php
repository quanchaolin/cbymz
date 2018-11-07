<script type='text/javascript' src='<?=base_url('static/plugins/SUI/js/zepto.js')?>' charset='utf-8'></script>
<script type='text/javascript' src='<?=base_url('static/plugins/SUI/js/sm.js')?>' charset='utf-8'></script>
<script type='text/javascript' src='<?=base_url('static/plugins/SUI/js/sm-extend.js')?>' charset='utf-8'></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
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