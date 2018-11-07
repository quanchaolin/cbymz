<?php $this->load->view('admin/header'); ?>

    <!--右侧布局-->
    <div style="margin:0 10px;">
        <blockquote class="layui-elem-quote">
            <a href="javascript:history.back();">
                <返回
            </a> &nbsp;&nbsp; 编辑信息
        </blockquote>
        <div class="layui-tab layui-tab-brief" lay-filter="msgtype">
            <ul class="layui-tab-title">
                <li data-type="text" <?php if($value['msgtype']=='text') echo "class=\"layui-this\""?>>文本消息</li>
                <li data-type="image" <?php if($value['msgtype']=='image') echo "class=\"layui-this\""?>>图片消息</li>
                <li data-type="voice" <?php if($value['msgtype']=='voice') echo "class=\"layui-this\""?>>语音消息</li>
                <li data-type="video" <?php if($value['msgtype']=='video') echo "class=\"layui-this\""?>>视频消息</li>
                <li data-type="music" <?php if($value['msgtype']=='music') echo "class=\"layui-this\""?>>音乐消息</li>
                <li data-type="news" <?php if($value['msgtype']=='news') echo "class=\"layui-this\""?>>图文消息（点击跳转到外链）</li>
                <li data-type="mpnews" <?php if($value['msgtype']=='mpnews') echo "class=\"layui-this\""?>>图文消息（点击跳转到图文消息页面）</li>
            </ul>
            <div class="layui-tab-content" style="height: 100px;">
                <div class="layui-tab-item <?php if($value['msgtype']=='text') echo "layui-show"?>">
                    <form action="<?=$this->baseurl?>save" method="post" class="w900 layui-form">
                        <input type="hidden" name="id" value="<?=$value['id']?>">
                        <input type="hidden" name="value[msgtype]" value="text">
                        <div class="layui-form-item">
                            <label class="layui-form-label">* 标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[title]" class="layui-input" value="<?= $value['title'] ?>">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">* 文本消息内容</label>
                            <div class="layui-input-block">
                                <textarea name="value[content]" class="layui-textarea" style="width: 480px;"><?= $value['content'] ?></textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="submit"  class="layui-btn">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="layui-tab-item <?php if($value['msgtype']=='image') echo "layui-show"?>">
                    <form action="<?=$this->baseurl?>save" method="post" class="w900 layui-form">
                        <input type="hidden" name="id" value="<?=$value['id']?>">
                        <input type="hidden" name="value[msgtype]" value="image">
                        <div class="layui-form-item">
                            <label class="layui-form-label">* 标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[title]" class="layui-input" value="<?= $value['title'] ?>">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">* 媒体ID</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[media_id]" id="image" class="layui-input" value="<?= $value['media_id'] ?>">
                            </div>
                            <button type="button"  class="layui-btn" id="btn-image">选择</button>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="submit"  class="layui-btn">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="layui-tab-item <?php if($value['msgtype']=='voice') echo "layui-show"?>">
                    <form action="<?=$this->baseurl?>save" method="post" class="w900 layui-form">
                        <input type="hidden" name="id" value="<?=$value['id']?>">
                        <input type="hidden" name="value[msgtype]" value="voice">
                        <div class="layui-form-item">
                            <label class="layui-form-label">* 标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[title]" class="layui-input" value="<?= $value['title'] ?>">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">* 媒体ID</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[media_id]" id="voice" class="layui-input" value="<?= $value['media_id'] ?>">
                            </div>
                            <button type="button"  class="layui-btn" id="btn-voice">选择</button>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="submit"  class="layui-btn">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="layui-tab-item <?php if($value['msgtype']=='video') echo "layui-show"?>">
                    <form action="<?=$this->baseurl?>save" method="post" class="w900 layui-form">
                        <input type="hidden" name="id" value="<?=$value['id']?>">
                        <input type="hidden" name="value[msgtype]" value="video">
                        <div class="layui-form-item">
                            <label class="layui-form-label">* 标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[title]" class="layui-input" value="<?= $value['title'] ?>">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">* 媒体ID</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[media_id]" id="video" class="layui-input" value="<?= $value['media_id'] ?>">
                            </div>
                            <button type="button"  class="layui-btn" id="btn-video">选择</button>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">图片的媒体ID</label>
                            <div class="layui-input-inline">
                                <input type="text" readonly name="value[thumb_media_id]" id="thumb_media_id" class="layui-input" value="<?= $value['thumb_media_id'] ?>">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">描述</label>
                            <div class="layui-input-block">
                                <textarea name="value[description]" id="description" class="layui-textarea" style="width: 480px;"><?= $value['description'] ?></textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="submit"  class="layui-btn">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="layui-tab-item <?php if($value['msgtype']=='music') echo "layui-show"?>">
                    <form action="<?=$this->baseurl?>save" method="post" class="w900 layui-form">
                        <input type="hidden" name="id" value="<?=$value['id']?>">
                        <input type="hidden" name="value[msgtype]" value="music">
                        <div class="layui-form-item">
                            <label class="layui-form-label">* 标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[title]" class="layui-input" value="<?= $value['title'] ?>">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">* 音乐链接</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[musicurl]" class="layui-input" value="<?= $value['musicurl'] ?>">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">* 高品质音乐链接</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[hqmusicurl]" class="layui-input" value="<?= $value['hqmusicurl'] ?>">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">音乐消息的描述</label>
                            <div class="layui-input-block">
                                <textarea name="value[description]" class="layui-textarea" style="width: 480px;"><?= $value['description'] ?></textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="submit"  class="layui-btn">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="layui-tab-item <?php if($value['msgtype']=='news') echo "layui-show"?>">
                    <form action="#" method="post" class="w900 layui-form">
                        <input type="hidden" name="news_id" value="<?=$value['id']?>">
                        <input type="hidden" name="news_title" value="<?=$value['title']?>">
                        <input type="hidden" name="value[msgtype]" value="news">
                        <table class="layui-table" style="width: 640px">
                            <tbody>
                            <?php foreach($value['push_item'] as $key=>$push_item):?>
                            <tr>
                                <td width="98%" class="news-list">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">* 标题</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="title" class="layui-input news_title" value="<?= $push_item['title'] ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">* 图片链接</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="picurl" class="layui-input" value="<?= $push_item['picurl'] ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">* 跳转的链接</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="url"  class="layui-input" value="<?= $push_item['url'] ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">消息的描述</label>
                                        <div class="layui-input-block">
                                            <textarea name="description" class="layui-textarea" style="width: 480px;"><?= $push_item['description'] ?></textarea>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($key==0):?>
                                        <div class="layui-form-mid btn-add"><i class="fa fa-plus-circle" aria-hidden="true"></i> </div>
                                    <?php else:?>
                                        <div class="layui-form-mid btn-del"><i class="fa fa-times" aria-hidden="true"></i></div>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="button"  class="layui-btn" id="news_submit">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="layui-tab-item <?php if($value['msgtype']=='mpnews') echo "layui-show"?>">
                    <form action="<?=$this->baseurl?>save" method="post" class="w900 layui-form">
                        <input type="hidden" name="id" value="<?=$value['id']?>">
                        <input type="hidden" name="value[msgtype]" value="mpnews">
                        <div class="layui-form-item">
                            <label class="layui-form-label">* 标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[title]" class="layui-input" value="<?= $value['title'] ?>">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">* 媒体ID</label>
                            <div class="layui-input-inline">
                                <input type="text" name="value[media_id]" id="mpnews" class="layui-input" value="<?= $value['media_id'] ?>">
                            </div>
                            <button type="button"  class="layui-btn" id="btn-mpnews">选择</button>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="submit"  class="layui-btn">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="<?= base_url('public/plugins/layui/layui.js') ?>"></script>
    <script>
        layui.use(['layer','element'], function(){
            var $ = layui.jquery
                ,layer = layui.layer
                ,element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块

            element.on('tab(msgtype)', function(elem){
                var msgtype=$(this).attr('data-type');
                $("input[name='msgtype']").val(msgtype);
            });
            $(function(){
                $('#btn-image').on('click',function(){
                    layer.open({
                        type: 2,
                        title:'浏览图片',
                        area: ['780px', '320px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: '<?=site_url('admin/material_image/get_image/')?>'
                    });
                });
                $('#btn-voice').on('click',function(){
                    layer.open({
                        type: 2,
                        title:'浏览语音',
                        area: ['780px', '320px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: '<?=site_url('admin/material_voice/get_voice/')?>'
                    });
                });
                $('#btn-video').on('click',function(){
                    layer.open({
                        type: 2,
                        title:'浏览视频',
                        area: ['640px', '320px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: '<?=site_url('admin/material_video/get_video/')?>'
                    });
                });
                $('#btn-mpnews').on('click',function(){
                    layer.open({
                        type: 2,
                        title:'浏览图文',
                        area: ['640px', '320px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: '<?=site_url('admin/material_news/get_news/')?>'
                    });
                });
                $(".btn-add").on('click',function(){
                    var  tr=$(this).parent().parent();
                    var shtml = '<tr><td width="98%" class="news-list"><div class="layui-form-item"><label class="layui-form-label">* 标题</label><div class="layui-input-inline"><input type="text" name="title" class="layui-input" value=""></div></div><div class="layui-form-item"><label class="layui-form-label">* 图片链接</label><div class="layui-input-inline"><input type="text" name="picurl" class="layui-input" value=""></div></div><div class="layui-form-item"><label class="layui-form-label">* 跳转的链接</label><div class="layui-input-inline"><input type="text" name="url" id="mpnews" class="layui-input" value=""></div></div><div class="layui-form-item"><label class="layui-form-label">消息的描述</label><div class="layui-input-block"><textarea name="description" class="layui-textarea" style="width: 480px;"></textarea></div></div></td><td><div class="layui-form-mid btn-del"><i class="fa fa-times" aria-hidden="true"></i></div></td></tr>';
                    tr.after(shtml);
                });
                $(document).on('click',".btn-del",function(){
                    var  tr=$(this).parent().parent();
                    tr.remove();
                });
                $("#news_submit").on('click',function(){
                    var id=$("input[name='news_id']").val()
                        ,url="<?=$this->baseurl?>save_news"
                        ,title=$("input[name='news_title']").val();
                    if(title==''){layer.msg('标题不能为空');return false;}
                    var data_ = {
                        title:title,
                        msgtype:'news'
                    } ;
                    var list=new Array();
                    $(".news-list").each(function(){
                        var divs=$(this).children(),
                            item_title=divs.eq(0).find("input").val(),
                            picurl=divs.eq(1).find("input").val(),
                            item_url=divs.eq(2).find("input").val(),
                            description=divs.eq(3).find("textarea").val();
                        var arr=[item_title,picurl,item_url,description];
                        if(item_title!='')
                        {
                            list.push(arr);
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: url ,
                        data: {id:id,value:data_,list:list},
                        cache:false,
                        dataType:"json",
                        beforeSend:function(){
                            layer.load(1);
                        },
                        complete:function(){
                            layer.closeAll('loading');
                        },
                        success: function(res){
                            if(res.errcode==0){
                                window.location.href="<?=$this->baseurl?>index";
                            }else{
                                layer.msg(res.errmsg);
                                return false ;
                            }
                        },
                        error:function(){
                            layer.msg('服务器繁忙,请稍后...');
                        }
                    });
                });
                $(".news_title").on('blur',function(){
                    var title=$(this).val();
                    $("input[name='news_title']").val(title);
                });
            });

        });
    </script>
<?php $this->load->view('admin/footer'); ?>