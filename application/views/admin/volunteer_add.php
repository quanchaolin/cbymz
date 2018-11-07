<?php $this->load->view('admin/header'); ?>

    <!--右侧布局-->
    <div style="margin:0 10px;">
        <blockquote class="layui-elem-quote">
            <a href="javascript:history.back();">
                <返回
            </a> &nbsp;&nbsp; 编辑信息
        </blockquote>
        <form action="#" method="post" class="w900 layui-form">
            <input type="hidden" name="id" value="<?= $value['id'] ?>">

            <div class="layui-form-item">
                <label class="layui-form-label">* 义工姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" class="layui-input" value="<?= $value['name'] ?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">微信昵称</label>
                <div class="layui-input-inline">
                    <input type="text" name="nickname" class="layui-input" value="<?= $value['nickname'] ?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">openid</label>
                <div class="layui-input-inline">
                    <input type="text" name="openid" id="openid" class="layui-input" value="<?= $value['openid'] ?>">
                </div>
                <button type="button"  class="layui-btn" id="btn-openid">选择</button>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">电话</label>
                <div class="layui-input-inline">
                    <input type="text" name="tel" class="layui-input" value="<?= $value['tel'] ?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">*电子邮箱</label>
                <div class="layui-input-inline">
                    <input type="email" name="email" class="layui-input" value="<?= $value['email'] ?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">发送到微信</label>
                <div class="layui-input-block">
                    <input type="checkbox" <?php if($value['send_weixin']==1) echo 'checked'?> name="send_weixin" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-block">
                <textarea name="content" id="content" class="layui-textarea"
                          style="width: 600px;"><?= $value['content'] ?></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button"  class="layui-btn" id="submit">立即提交</button>
                </div>
            </div>
        </form>
    </div>

    <script src="<?= base_url('public/plugins/layui/layui.js') ?>"></script>
    <script>
        layui.use(['layer','form'], function () {
            var layer = layui.layer;
            var $ = layui.jquery; //由于layer弹层依赖jQuery，所以可以直接得到
            $(function(){
                $('#btn-openid').on('click',function(){
                    layer.open({
                        type: 2,
                        title:'详情页',
                        area: ['640px', '320px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: '<?=site_url('admin/user/get_user/')?>'
                    });
                });
                $(document).on('click','#submit',function(){
                    var id=$("input[name='id']").val()
                        ,url="<?=$this->baseurl?>save"
                        ,name=$("input[name='name']").val()
                        ,nickname=$("input[name='nickname']").val()
                        ,openid=$("input[name='openid']").val()
                        ,tel=$("input[name='tel']").val()
                        ,email=$("input[name='email']").val()
                        ,send_weixin=$("input[name='send_weixin']:checked").val()
                        ,content=$("#content").val();
                    if(name==''){layer.msg('义工姓名不能为空');return false;}
                    if(email==''){layer.msg('邮箱不能为空');return false;}
                    var weixin=0;
                    if(send_weixin=='on'){
                        weixin=1;
                        if(openid=='')
                        {
                            layer.msg('openid不能为空');return false;
                        }
                    }
                    var data_ = {
                        name:name,
                        nickname:nickname,
                        openid:openid,
                        tel:tel,
                        email:email,
                        send_weixin:weixin,
                        content:content
                    } ;
                    $.ajax({
                        type: "POST",
                        url: url ,
                        data: {id:id,value:data_},
                        cache:false,
                        dataType:"json",
                        beforeSend:function(){
                            layer.load(1);
                        },
                        complete:function(){
                            layer.closeAll('loading');
                        },
                        success: function(data){
                            if(data.errcode==0){
                                layer.msg(data.errmsg);
                                window.location.href='<?=$this->baseurl?>';
                            }else{
                                layer.msg(data.errmsg);
                                return false ;
                            }
                        },
                        error:function(){
                            layer.msg('服务器繁忙,请稍后...');
                        }
                    });
                });
            });
        });
    </script>
<?php $this->load->view('admin/footer'); ?>