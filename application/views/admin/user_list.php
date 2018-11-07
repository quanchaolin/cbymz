<?php $this->load->view('admin/header'); ?>
    <!--右侧布局-->
    <div style="margin:0px; background-color: white; margin:0 10px;">
        <blockquote class="layui-elem-quote">
            <a href="javascript:void(0)" class="layui-btn layui-btn-small btn-refresh"><i class="fa fa-refresh" aria-hidden="true"></i> 同步</a>
            <form class="layui-form" style="float:right;">
                <div class="layui-form-item" style="margin:0;">
                    <label class="layui-form-label">用户昵称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="keywords" placeholder="支持模糊查询.." autocomplete="off" class="layui-input" value="<?= $keywords ?>">
                    </div>
                    <div class="layui-form-mid layui-word-aux" style="padding:0;">
                        <button lay-filter="search" class="layui-btn" lay-submit><i class="fa fa-search" aria-hidden="true"></i> 查询</button>
                    </div>
                </div>
            </form>
        </blockquote>
        <table class="layui-table">
            <thead>
            <tr>
                <th width="100">头像</th>
                <th width="100">用户昵称</th>
                <th width="100">性别</th>
                <th width="100">关注时间</th>
                <th width="120">用户所在城市</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $key => $value): ?>
                <tr>
                    <td>
                        <a href="<?=$value['headimgurl']?>" target="_blank">
                            <img src="<?=$value['headimgurl_thumb']?>" width="64" height="64">
                        </a>
                    </td>
                    <td><?= $value['nickname'] ?><br><?= $value['remark'] ?></td>
                    <td><?= $value['sex'] ?></td>
                    <td><?= $value['subscribe_time'] ?></td>
                    <td><?= $value['city'] ?></td>
                    <td>
                        <a href="javascript:void(0);" data-openid="<?=$value['openid'] ?>" class="detail">详情</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="layui-laypage layui-laypage-default">
            <?= $pages ?>
            <span class="layui-laypage-count">共 <?= $count ?> 条</span>
        </div>
    </div>

    <script src="<?= base_url('public/plugins/layui/layui.js') ?>"></script>
    <script>
        layui.use(['layer', 'form', 'element'], function () {
            var layer = layui.layer
                , form = layui.form
                ,element = layui.element;
            var $ = layui.jquery; //由于layer弹层依赖jQuery，所以可以直接得到
            $('.detail').on('click',function(){
                var openid=$(this).attr('data-openid');
                layer.open({
                    type: 2,
                    title:'详情页',
                    area: ['780px', '450px'],
                    fixed: false, //不固定
                    maxmin: true,
                    content: '<?=$this->baseurl.'detail?openid='?>'+openid
                });
            });
            $(document).on('click','.btn-refresh',function(){
                var url="<?=$this->baseurl?>refresh";
                $.ajax({
                    type: "POST",
                    url: url ,
                    data: {},
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
                            window.location.reload();
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

    </script>
<?php $this->load->view('admin/footer'); ?>