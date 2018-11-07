<div class="col-md-3">
    <!-- Profile Image -->
    <div class="box box-primary">
        <div class="box-body box-profile" >
            <!-- Current avatar -->
            <div class="avatar-view" title="更改头像">
                <img class="profile-user-img img-responsive img-circle" id="avatar-view" src="<?=$value['head_img_url']?>" alt="用户头像">
            </div>
            <!-- Cropping modal -->
            <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="avatar-form" action="<?=$this->baseurl.'crop'?>" enctype="multipart/form-data" method="post">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">&times;</button>
                                <h4 class="modal-title" id="avatar-modal-label">更改头像</h4>
                            </div>
                            <div class="modal-body">
                                <div class="avatar-body">

                                    <!-- Upload image and data -->
                                    <div class="avatar-upload">
                                        <input class="avatar-src" name="avatar_src" type="hidden">
                                        <input class="avatar-data" name="avatar_data" type="hidden">
                                        <label for="avatarInput">本地上传</label>
                                        <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                    </div>

                                    <!-- Crop and preview -->
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="avatar-wrapper"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="avatar-preview preview-lg"></div>
                                            <div class="avatar-preview preview-md"></div>
                                            <div class="avatar-preview preview-sm"></div>
                                        </div>
                                    </div>

                                    <div class="row avatar-btns">
                                        <div class="col-md-9">
                                            <div class="btn-group">
                                                <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">左旋转</button>
                                                <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button">-15deg</button>
                                                <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button">-30deg</button>
                                                <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button">-45deg</button>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">右旋转</button>
                                                <button class="btn btn-primary" data-method="rotate" data-option="15" type="button">15deg</button>
                                                <button class="btn btn-primary" data-method="rotate" data-option="30" type="button">30deg</button>
                                                <button class="btn btn-primary" data-method="rotate" data-option="45" type="button">45deg</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary btn-block avatar-save" type="submit">保存 </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="modal-footer">
                              <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div><!-- /.modal -->
            <!-- Loading state -->
            <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
            <h3 class="profile-username text-center"><?=$value['true_name']?></h3>

            <p class="text-muted text-center"><?=$value['positional_titles']?></p>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>项目数</b> <a class="pull-right"><?=$value['project_count']?></a>
                </li>
                <li class="list-group-item">
                    <b>登录次数</b> <a class="pull-right"><?=$value['logins']?></a>
                </li>
                <li class="list-group-item">
                    <b>审批数</b> <a class="pull-right"><?=$value['declare_count']?></a>
                </li>
            </ul>

            <a href="<?=$this->baseurl.'change_pwd'?>" class="btn btn-danger btn-block"><b>修改密码</b></a>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- About Me Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">关于我</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <strong><i class="fa fa-book margin-r-5" onclick="javascript:location.href='<?=$this->baseurl.'education'?>'" style="cursor: pointer"></i> 教育背景</strong>
            <?php if($edu_list):?>
            <?php foreach($edu_list as $item):?>
            <p class="text-muted">
                <?=$item['school_year']?>,<?=$item['school_name']?>
            </p>
            <?php endforeach;?>
            <?php else:?>
                <p class="text-muted">
                    暂无您的教育信息
                    </br>
                    <a class="green" href="<?=$this->baseurl.'education'?>">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </p>
            <?php endif;?>
            <hr>

            <strong><i class="fa fa-map-marker margin-r-5"></i> 位置</strong>

            <p class="text-muted"><?=$value['area_name']?></p>

            <hr>

            <strong><i class="fa fa-pencil margin-r-5"></i> 技能</strong>

            <p>
                <span class="label label-info">dd</span>
            </p>

            <hr>

            <strong><i class="fa fa-file-text-o margin-r-5 " onclick="javascript:location.href='<?=$this->baseurl.'note'?>'"></i> 笔记</strong>

            <?php if($note_list):?>
                <?php foreach($note_list as $item):?>
                    <p class="text-muted">
                        <?=date('Y-m-d',strtotime($item['add_time']))?>,<?=$item['title']?>
                    </p>
                <?php endforeach;?>
            <?php else:?>
                <p class="text-muted">
                    暂无笔记
                    </br>
                    <a class="green" href="<?=$this->baseurl.'note'?>">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </p>
            <?php endif;?>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>