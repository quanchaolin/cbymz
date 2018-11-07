<?php $this->load->view('header');?>
<style type="text/css">
    .col-50{
        border-top: 1px solid #ebebeb;
        border-right: 1px solid #ebebeb;
    }
    .col-50 .card{
        margin: 0;
        overflow: hidden;
        position: relative;
        box-shadow: none;
    }
    .card-header{padding: 0.45rem}
    .card-content-inner{padding: 0.45rem}
</style>
    <link rel="stylesheet" href="<?=base_url('static/css/app.css?1')?>">
    <div class="page-group">
        <!-- 单个page ,第一个.page默认被展示-->
        <div class="page" id="page-home">
            <!-- 标题栏 -->

            <!-- 工具栏 -->
            <nav class="bar bar-tab">
                <a class="tab-item external on active" href="#">
                    <span class="icon icon-home"></span>
                    <span class="tab-label">首页</span>
                </a>
                <a class="tab-item external" href="<?=base_url('qfxz/category')?>">
                    <span class="icon icon-app"></span>
                    <span class="tab-label">分类</span>
                </a>
                <a class="tab-item external" href="#">
                    <span class="icon icon-me"></span>
                    <span class="tab-label">我的</span>
                </a>
            </nav>
            <!-- 这里是页面内容区 -->
            <div class="content">
                <div class="header_banner">
                    <img src="<?=base_url('uploads/image/20161103/1106_1.jpg')?>" width="100%">
                </div>
                <section class="shop_info">
                    <!--<div class="hd_intro_text">
                        <span class="hd_intro_icon">特别声明</span>
                    </div>-->
                    <div class="hd_intro">
                        <p>木雅佐钦大圆满吉祥金刚萨埵寺、拉萨芒康萨迦派吉日寺佛事<br/>
                            咨询电话：15281559889、18783691666<br>
                            寺院联系人：达布师父<br>
                            汉地义工师兄：13708803022<br>
                            汉地义工师兄：13305714090<br><br>

                            《慈悲圆满洲》是木雅佐钦大圆满吉祥金刚萨埵寺和拉萨芒康萨迦派吉日寺的公众平台，应众多弟子一再祈请上师三宝而成。其中《功德海》是经由《木雅佐钦大圆满吉祥金刚萨埵寺》《拉萨芒康萨迦派吉日寺》授权，由《慈悲院》道场的金刚师兄们共同发心协助寺院管理，闭关中心达布师父负责对每份功德心愿单进行登记，同时根据具体的事项交与寺院僧众执行。本道场义工也会应各位同修及善信的需要配合寺院完成各项佛事的工作。寺院僧众对功德主所求愿望做如法圆满回向。<br><br>
                            【特别声明】由于本寺院为非营利性机构，因涉及善款支付需要，特授权“昆明市五华区倾情时尚时装店”的义工师兄向第三方支付平台提供相关具法律效力的证明材料，以圆满本公众号的搭建。 您做佛事所支付的款项均定期公布，并由义工负责将相关善款直接交与闭关中心上师桑格堪布仁波切。
                        </p>
                    </div>
                </section>
                <?php foreach($list as $item):?>
                    <div class="list-block">
                        <h3 class="list-title"><p class="p"><?=$item['name']?></p></h3>

                        <ul class="list-wrapper">
                                <div class="row no-gutter">
                                    <?php foreach($item['product_item'] as $key=>$goods):?>
                                    <?php if($key%2==0){echo "</div><div class=\"row no-gutter\">";}?>
                                    <div class="col-50">
                                        <div class="card">
                                            <div valign="bottom" class="card-header color-white no-border">
                                                <a href="<?=$goods['product_url']?>" external title="">
                                                    <img class='card-cover' src="<?=$goods['main_img']?>" alt="" width="100%">
                                                </a>
                                            </div>
                                            <div class="card-content">
                                                <div class="card-content-inner">
                                                    <a href="<?=$goods['product_url']?>"  external title="">
                                                        <h3 class="d-title"><?=$goods['name']?></h3>
                                                    </a>
                                                    <?php if($goods['can_buy']==0):?>
                                                        <p class="d-price"><em class="h" style="font-weight: 700"><?=$goods['remark']?></em></p>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                        </ul>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php $this->load->view('footer');?>