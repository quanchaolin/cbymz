<?php $this->load->view('admin/header'); ?>
    <!--右侧布局-->
    <div style="margin:0 10px;">
        <blockquote class="layui-elem-quote" style="min-height: 30px">
            <form class="layui-form" style="float:right;">
                <div class="layui-form-item" style="margin-bottom:0">
                    <label class="layui-form-label">用户名</label>
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
                <th width="15">序号</th>
                <th width="60">用户名</th>
                <th width="100">IP地址</th>
                <th width="70">url</th>
                <th width="70">客户端信息</th>
                <th width="80">添加时间</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $key => $value): ?>
                <tr>
                    <td><?= $key+1?></td>
                    <td><?= $value['true_name'] ?></td>
                    <td><?= $value['ip'] ?></td>
                    <td><?= $value['url'] ?></td>
                    <td><?= $value['user_agent'] ?></td>
                    <td><?= $value['add_time'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="layui-laypage layui-laypage-default">
            <?= $pages ?>
            <span class="layui-laypage-count">共 <?= $count ?> 条</span>
        </div>
    </div>
<?php $this->load->view('admin/footer'); ?>