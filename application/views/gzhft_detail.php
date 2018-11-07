<?php $this->load->view('header');?>
<link rel="stylesheet" href="<?=base_url('static/pay/css/style.css?1')?>">
<style type="text/css">
    .pay_body{background: url("<?=$value['detail_img']?>") center top no-repeat #c80106;background-size: 100%;padding-bottom: 15px}
</style>
<div class="page-group">
    <div class="page" id="page-detail">
        <input type="hidden" name="id" value="<?=$value['id']?>"/>
        <input type="hidden" name="openid" value="<?=$openid?>"/>
        <input type="hidden" name="min_price" value="<?=$value['min_price']?>"/>
        <input type="hidden" name="can_buy" value="<?=$value['can_buy']?>"/>
        <div class="content">
            <div class="pay_body">
                <?php if($value['show_price_input']==1):?>
                <div class="pay_title"><?=$value['pay_title']?></div>
                <ul>
                    <?php foreach($price as $val):?>
                        <li><span class="pay_txt1" data-value="<?=$val?>" ><?=$val?>元</li>
                    <?php endforeach;?>
                    <div class="clear"></div>
                </ul>
                <?php endif;?>
                <div><input type="number" placeholder="或者输入随喜金额" value="<?php if($value['min_price']!=1){echo $value['min_price'];}?>" class="pay_txt"><span class="yuan">元</span></div>
                <div><input type="button" value="<?=$value['button']?>" class="pay_btn"></div>
                <?php if($value['detail']!=''):?>
                <div class="pay_text2">
                    <?=$value['detail']?>
                </div>
                <?php endif;?>
            </div>
            <div class="popup-box2">
                <div class="popup-content">
                    <h3><a class="close"></a>提示</h3>
                    <p class="popup-text">随喜金额不能低于<?=$value['min_price']?>元，请重新选择！</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="picker-modal picker-columns remove-on-close" style="display: block">
    <div class="content">
        <header class="bar bar-nav">
            <button class="button button-link pull-right"><i class="picker-close"></i></button>
           <!-- <i class="picker-close" id="picker_close">sss</i>-->
            <h1 class="title">您的心愿单</h1>
        </header>
        <nav class="bar-tab" style="position: fixed;bottom: 0">
            <div class="row">
                <input type="button" data-transition="slide-out" class="button button-big button-fill button-danger ok" value="确定">
            </div>
        </nav>
        <div class="list-block" style="margin:0 0 0.4rem;">
            <ul>
                <li class="align-top">
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-input">
                                <textarea id="content" placeholder="功德主所求愿望"><?=$order['content']?></textarea>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-input">
                                <input type="text" id="name" value="<?=$order['receiver_name']?>" placeholder="功德主名字">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-input">
                                <input type="tel" class="" id="tel" value="<?=$order['receiver_mobile']?>" placeholder="联系电话">
                            </div>
                        </div>
                    </div>
                </li>
                <?php if($value['remark']!=''):?>
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <p style="color:#7b0c00;font-size: 0.85rem;"><?=$value['remark']?></p>
                            </div>
                        </div>
                    </li>
                <?php endif;?>
            </ul>
        </div>
        <!--<p></p>
        <input type="button" data-transition="slide-out" class="button button-big button-fill button-danger ok" style="width: 90%;margin: 0 auto" value="确定">-->
    </div>
</div>
<?php $this->load->view('footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".close").on('click',function () {
            $('html').removeClass('not-allow-scroll');
            $('.popup-box2').hide();
        });
        var min_price=parseInt($("input[name='min_price']").val());
        $(".pay_txt").on('blur',function(){
            $(".pay_txt1").removeClass('on');
        });
        $(".pay_txt1").on('click',function () {
            $(".pay_txt1").removeClass("on");
            $(this).addClass("on");
            $(".pay_txt").val($(this).attr('data-value'));
        });
        $('.pay_btn').on('click',function () {
            var num=$(".pay_txt").val();
            if(num<min_price)
            {
                $('.popup-box2').show();
                return false;
            }
            else
            {
                var picker=$('.picker-modal');
                picker.addClass('modal-in');
                picker.removeClass('modal-out');
                return false;
            }
        });
        $('.picker-close').click(function(){
            var picker=$('.picker-modal');
            picker.addClass('modal-out');
            picker.removeClass('modal-in');
        });
        $('.ok').on('click',function(){
            var num=$(".pay_txt").val()
                ,id=$("input[name='id']").val()
                ,openid=$("input[name='openid']").val()
                ,content=$('#content').val()
                ,name=$('#name').val()
                ,tel=$('#tel').val();
            if(content=='') {alert('请填写功德主所求愿望');return false;}
            if(name=='') {alert('请填写功德主姓名');return false;}
            if(tel=='') {alert('请填写联系电话');return false;}
            var _data={
                openid:openid,
                total:num,
                content:content,
                receiver_name:name,
                receiver_mobile:tel
            };
            $.ajax({
                type: "POST",
                url: '<?=site_url('order/index')?>' ,
                data: {id:id,value:_data},
                cache:false,
                dataType:"json",
                beforeSend:function(){
                    $('.ok').val('处理中...').attr('disabled','disabled');
                },
                success: function(res){
                    if(res.errcode!=0){
                        alert(res.errmsg);
                        $('.ok').val('确定').removeAttr('disabled');
                        return false;
                    }
                    else{
                        var trans_id=res.data.trans_id;
                        var redirect_url=res.data.redirect_url+'?trans_id='+trans_id;
                        window.location.href=redirect_url;
                    }
                },
                error:function(){
                    $('.ok').val('确定').removeAttr('disabled');
                    alert("服务器繁忙，请稍后...");
                }
            });
        });
    });
</script>
