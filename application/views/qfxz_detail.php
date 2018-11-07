<?php $this->load->view('header');?>
    <link rel="stylesheet" href="<?=base_url('static/css/app.css?1')?>">
    <div class="page-group">
        <div class="page" id="page-detail">
            <input type="hidden" name="id" value="<?=$value['id']?>"/>
            <input type="hidden" name="openid" value="<?=$openid?>"/>
            <input type="hidden" name="min_price" value="<?=$value['min_price']?>"/>
            <input type="hidden" name="can_buy" value="<?=$value['can_buy']?>"/>
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left external" href="<?=site_url('qfxz/index')?>">
                    <span class="icon icon-left"></span>
                    返回
                </a>

                <h1 class="title"><?=$value['name']?></h1>
            </header>
            <!-- 工具栏 -->
            <nav class="bar bar-tab">
                <div class="row">
                    <input type="button" data-transition="slide-out" class="button button-big button-fill button-danger open-buy" value="<?=$value['button']?>"/>
                </div>


            </nav>
            <!-- 这里是页面内容区 -->
            <div class="content">
                <div class="page-detail">
                    <div class="swiper-container swiper-container-horizontal" data-space-between="10">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img class="card-cover" src="<?=$value['detail_img']?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="content-block goods-card">
                        <h3><?=$value['name']?></h3>

                    </div>
                    <div class="content-padded">
                        <?=$value['detail']?>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup popup-buy">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-right close-popup">
                    取消
                </a>
                <h1 class="title">您的心愿单</h1>
            </header>
            <div class="content native-scroll">
                <?php if($value['show_price_input']):?>
                <div class="pay_body">
                    <p class="pay_title"><?=$value['pay_title']?></p>
                    <ul>
                        <?php foreach($price as $val):?>
                            <li><input type="text" class="pay_txt1" value="<?=$val?>元" data-value="<?=$val?>" readonly=""></li>
                        <?php endforeach;?>
                        <div class="clear"></div>
                    </ul>
                </div>
                <?php endif;?>
                <div class="gw_num">
                    <em class="jian">-</em>
                    <input type="number" placeholder="" value="<?php if($value['min_price']!=1){echo $value['min_price'];}?>" class="num"/>
                    <em class="add">+</em>
                </div>
                <div class="content-inner">
                    <div class="content-block">
                        <div class="list-block" style="margin: 0.4rem 0;">
                            <ul>
                                <?php if($value['other_content']):?>
                                <li class="align-top">
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-input">
                                                <textarea id="other_name" placeholder="<?=$value['placeholder']?>"><?=$order['other_name']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php endif;?>
                                <?php if($value['content_show']):?>
                                <li class="align-top">
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-input">
                                                <textarea id="content" placeholder="功德主所求愿望"><?=$order['content']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php endif;?>
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
                        <p></p>
                        <p><a class="button button-danger button-fill okbtn" id="submit">确定</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('footer');?>
<script>
    $(document).on('click','.open-buy', function () {
        $.popup('.popup-buy');
    });
    $(document).ready(function(){
        var can_buy=parseInt($("input[name='can_buy']").val());
        var min_price=parseInt($("input[name='min_price']").val());
        if(can_buy==0)
        {
            $(".open-buy").removeClass('button-danger');
            $(".open-buy").addClass('button-dark').attr('disabled',true);
        }
        $(".pay_txt1").on('click',function () {
            $(".pay_txt1").removeClass("on");
            $(this).addClass("on");
            $(".num").val($(this).attr('data-value'));
        });
        $(".num").on('blur',function(){
            $(".pay_txt1").removeClass('on');
        });
    //加的效果
        $(".add").click(function(){
            $(".pay_txt1").removeClass('on');
            var n=$(this).prev().val();
            if(n==''){n=0}
            var num=parseInt(n)+1;
            if(num<min_price){num=min_price}
            $(this).prev().val(num);
        });
        //减的效果
        $(".jian").click(function(){
            $(".pay_txt1").removeClass('on');
            var n=$(this).next().val();
            if(n==''){n=0}
            var num=parseInt(n)-1;
            if(num<min_price){ num=min_price}
            $(this).next().val(num);
        });
        $(document).on('click','#submit',function(){
            var id=$("input[name='id']").val()
                ,openid=$("input[name='openid']").val()
                ,num=$('.num').val()
                ,other_name=$("#other_name").val()
                ,content=$('#content').val()
                ,name=$('#name').val()
                ,tel=$('#tel').val();
            if(num<min_price || num==''){$.alert('随喜金额不能小于'+min_price);return false;}
            if(content=='') {$.alert('请填写功德主所求愿望');return false;}
            if(name=='') {$.alert('请填写功德主姓名');return false;}
            if(tel=='') {$.alert('请填写联系电话');return false;}
            if(id==0 || openid=='')   return;
            if(other_name=='undefined'){
                other_name='';
            }
            var _data = {
                time:<?php echo time();?>,
                openid:openid,
                total:num,
                other_name:other_name,
                receiver_name:name,
                content:content,
                receiver_mobile:tel
            };
            $.ajax({
                type: "POST",
                url: '<?=site_url('order/index')?>',
                data: {id:id,value:_data},
                cache:false,
                dataType:"json",
                beforeSend:function(){
                    $.showPreloader('正在处理，请稍后');
                },
                complete:function(){
                    $.hidePreloader();
                },
                success: function(res){
                    if(res.errcode!=0){
                        $.alert(res.errmsg);
                        return false;
                    }
                    else {
                        var trans_id=res.data.trans_id;
                        var redirect_url=res.data.redirect_url+'?trans_id='+trans_id;
                        window.location.href=redirect_url;
                    }
                },
                error:function(){
                    $.alert("服务器繁忙,请稍后");
                }
            });
        });
    });
</script>