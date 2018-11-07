<?php $this->load->view('header');?>

<link rel="stylesheet" href="<?=base_url('static/css/app.css?1')?>">
<div class="page-group">
    <input type="hidden" name="id" value="<?=$value['id']?>"/>
    <input type="hidden" name="openid" value="<?=$openid?>"/>
    <div class="page" id="page-detail">
        <header class="bar bar-nav">
            <h1 class="title">您的心愿单</h1>
        </header>
        <nav class="bar bar-tab">
            <div class="row">
                <a href="#" data-transition="slide-out" class="tab-item button button-big button-fill button-danger " id="submit" style="height: 2.5rem;">确定</a>
            </div>
        </nav>
        <!-- 这里是页面内容区 -->
        <div class="content">
            <div class="content-inner">
                <div class="content-block">
                    <div class="list-block">
                        <ul>
                            <?php if($value['other_content']):?>
                            <li>
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-input">
                                            <input type="text" id="other_name" value="<?=$order['other_name']?>" placeholder="<?=$value['placeholder']?>">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php endif;?>
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
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer');?>
<script>
    $.popup('.popup-buy');
    var type='<?=$type?>';
    $(document).ready(function(){
        $(document).on('click','#submit',function(){
            var id=$("input[name='id']").val()
                ,openid=$("input[name='openid']").val()
                ,content=$('#content').val()
                ,name=$('#name').val()
                ,other_name=$('#other_name').val()
                ,tel=$('#tel').val()
                ,email=$('#email').val();
            if(name=='') {$.alert('请填写功德主姓名');return false;}
            if(content=='') {$.alert('请填写功德主所求愿望');return false;}
            if(tel=='') {$.alert('请填写联系电话');return false;}
            if(id==0 || openid=='')   return;
            if(other_name=='undefined'){
                other_name='';
            }
            var _data = {
                time:<?php echo time();?>,
                openid:openid,
                other_name:other_name,
                receiver_name:name,
                content:content,
                receiver_mobile:tel,
                receiver_email:email
            };
            $.ajax({
                type: "POST",
                url: '<?=site_url('order/free_order')?>',
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