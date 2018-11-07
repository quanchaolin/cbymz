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
                <label class="layui-form-label">* 分组名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="group_name" class="layui-input" value="<?= $value['group_name'] ?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-block">
                <textarea name="remark" id="remark" class="layui-textarea"
                          style="width: 600px;"><?= $value['remark'] ?></textarea>
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
                $(document).on('click','#submit',function(){
                    var id=$("input[name='id']").val()
                        ,url="<?=$this->baseurl?>save"
                        ,group_name=$("input[name='group_name']").val()
                        ,remark=$("#remark").val();
                    if(group_name==''){layer.msg('分组名称不能为空');return false;}
                    var data_ = {
                        group_name:group_name,
                        remark:remark
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