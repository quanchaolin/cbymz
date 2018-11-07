<?php $this->load->view('admin/header'); ?>
    <!--右侧布局-->
    <div style="margin:0 10px;">
        <blockquote class="layui-elem-quote">
            <form class="layui-form">
                <div class="layui-form-item" style="margin:0;">
                    <label class="layui-form-label">文件名称</label>
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
                <th width="30">选择</th>
                <th width="100">文件名称</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $key => $value): ?>
                <tr>
                    <td><input type="radio" name="choose" data-thumb-media-id="<?=$value['thumb_media_id']?>" data-description="<?=$value['description']?>" value="<?= $value['media_id'] ?>" title="选择"></td>
                    <td><?= $value['name'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="layui-laypage layui-laypage-default">
            <?= $pages ?>
            <span class="layui-laypage-count">共 <?= $count ?> 条</span>
        </div>
        <div class="layui-input-inline" style="float: right">
            <button type="button"  class="layui-btn" id="closeIframe">关闭</button>
            <button type="button"  class="layui-btn" id="transmit">立即提交</button>
        </div>
    </div>

    <script src="<?= base_url('public/plugins/layui/layui.js') ?>"></script>
    <script>
        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
        layui.use(['jquery'], function () {
            var $ = layui.jquery; //由于layer弹层依赖jQuery，所以可以直接得到
            $('#transmit').on('click', function(){
                var media_id=$("input[name='choose']:checked").val();
                var thumb_media_id=$("input[name='choose']:checked").attr('data-thumb-media-id');
                var description=$("input[name='choose']:checked").attr('data-description');
                if(media_id!=undefined)
                {
                    parent.document.getElementById('video').value=media_id;
                    parent.document.getElementById('thumb_media_id').value=thumb_media_id;
                    parent.document.getElementById('description').value=description;
                }
                parent.layer.close(index);
            });
            $(function(){
                $('#closeIframe').on('click',function(){
                    parent.layer.close(index);
                });

            });

        });

    </script>
<?php $this->load->view('admin/footer'); ?>