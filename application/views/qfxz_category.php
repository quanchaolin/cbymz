<?php $this->load->view('header');?>
    <link rel="stylesheet" href="<?=base_url('static/css/app.css')?>">
    <div class="page-group">
        <!-- 单个page ,第一个.page默认被展示-->
        <div class="page" id="page-category">
            <!-- 标题栏 -->
            <header class="bar bar-nav">
                <div class="searchbar">
                    <div class="search-input">
                        <label class="icon icon-search" for="search"></label>
                        <input type="search" id="search" placeholder="输入关键字...">
                    </div>
                </div>
            </header>
            <!-- 工具栏 -->
            <nav class="bar bar-tab">
                <a class="tab-item external" href="<?=site_url('qfxz/index')?>">
                    <span class="icon icon-home"></span>
                    <span class="tab-label">首页</span>
                </a>
                <a class="tab-item external on active" href="#">
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
                <div class="menu-left">
                    <a href="#tab0" class="tab-link active">全部</a>
                    <?php foreach($category as $value):?>
                    <a href="#tab<?=$value['id']?>" class="tab-link"><?=$value['name']?></a>
                    <?php endforeach;?>
                </div>
                <div class="tabs menu-right">
                    <div id="tab0" class="tab active">
                        <div class="content-padded">
                            <h5>全部</h5>
                            <ul class="list-wrapper">
                                <?php foreach($list as $item):?>
                                    <?php foreach($item['product_item'] as $goods):?>
                                        <li class="list-item">
                                            <a href="<?=$goods['product_url']?>" external>
                                                <img src="<?=$goods['main_img']?>">
                                                <span><?=$goods['name']?></span>
                                            </a>
                                        </li>
                                    <?php endforeach;?>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <?php foreach($category as $value):?>
                    <div id="tab<?=$value['id']?>" class="tab">
                        <div class="content-padded">
                            <h5><?=$value['name']?></h5>
                            <ul class="list-wrapper">
                                <?php foreach($list[$value['id']]['product_item'] as $goods):?>
                                    <li class="list-item">
                                        <a href="<?=$goods['product_url']?>" external>
                                            <img src="<?=$goods['main_img']?>">
                                            <span><?=$goods['name']?></span>
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('footer');?>