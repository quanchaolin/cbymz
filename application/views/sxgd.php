<?php $this->load->view('header');?>
<link rel="stylesheet" href="<?=base_url('static/css/app.css?1')?>">
<div class="page-group">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page" id="page-detail">
        <input type="hidden" name="id" value="<?=$value['id']?>"/>
        <input type="hidden" name="openid" value="<?=$openid?>"/>
        <input type="hidden" name="min_price" value="<?=$value['min_price']?>"/>
        <!-- 标题栏 -->
        <!-- 工具栏 -->
        <nav class="bar bar-tab">
            <div class="row">
                <a href="#" data-transition="slide-out" class="tab-item button button-big button-fill button-danger open-buy">随喜发心
                </a>
            </div>
        </nav>
        <!-- 这里是页面内容区 -->
        <div class="content">
            <div class="page-detail">
                <div class="content-block">
                    <?=$value['detail']?>
                </div>
            </div>
        </div>
    </div>
    <div class="popup popup-buy">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-right close-popup" style="display:none;">
                取消
            </a>
            <h1 class="title">您的心愿单</h1>
        </header>
        <div class="content native-scroll">
            <div class="pay_body">
                <ul>
                    <?php foreach($price as $val):?>
                        <li><input type="text" class="pay_txt1" value="<?=$val?>元" data-value="<?=$val?>" readonly=""></li>
                    <?php endforeach;?>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="gw_num">
                <em class="jian">-</em>
                <input type="number" value="<?php if($value['min_price']!=1){echo $value['min_price'];}?>" placeholder="" class="num"/>
                <em class="add">+</em>
            </div>
            <div class="content-inner">
                <div class="content-block">
                    <div class="list-block">
                        <ul>
                            <li>
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-input">
                                            <input type="text" id="name" value="<?=$order['receiver_name']?>" placeholder="功德主名字">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- Text inputs -->
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
                                            <input type="tel" class="" value="<?=$order['receiver_mobile']?>" id="tel" placeholder="联系电话">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-input">
                                            <input type="email" id="email" value="<?=$order['receiver_email']?>"  placeholder="邮箱地址(可选填)">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php if($value['remark']!=''):?>
                                <li>
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <p style="color:#7b0c00;font-weight: 700"><?=$value['remark']?></p>
                                        </div>
                                    </div>
                                </li>
                            <?php endif;?>
                        </ul>
                    </div>
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
    $.popup('.popup-buy');
    $(document).ready(function(){
        var min_price=parseInt($("input[name='min_price']").val());
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
                ,content=$('#content').val()
                ,name=$('#name').val()
                ,tel=$('#tel').val()
                ,email=$('#email').val();
            if(num<min_price || num==''){$.alert('随喜金额不能小于'+min_price);return false;}
            if(name=='') {$.alert('请填写功德主姓名');return false;}
            if(content=='') {$.alert('请填写功德主所求愿望');return false;}
            if(tel=='') {$.alert('请填写联系电话');return false;}
            if(id==0 || openid=='')   return;
            var _data = {
                time:<?php echo time();?>,
                openid:openid,
                total:num,
                receiver_name:name,
                content:content,
                receiver_mobile:tel,
                receiver_email:email
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