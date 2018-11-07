<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" href="<?=base_url('vendor/cropperjs/dist/cropper.min.css')?>">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$this->name?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/common/main/')?>"><i class="fa fa-dashboard"></i>主页</a></li>
            <li><a href="<?=$this->baseurl.'index'?>">个人中心</a></li>
            <li class="active">密码修改</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <a href="<?=$this->baseurl.'crop'?>">
                            <img class="profile-user-img img-responsive img-circle" src="<?=$value['head_img_url']?>" alt="用户头像">
                        </a>
                        <h3 class="profile-username text-center"><?=$value['true_name']?></h3>

                        <p class="text-muted text-center"><?=$value['positional_titles']?></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>项目数</b> <a class="pull-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>登录次数</b> <a class="pull-right"><?=$value['logins']?></a>
                            </li>
                            <li class="list-group-item">
                                <b>审批数</b> <a class="pull-right">13,287</a>
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
                        <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

                        <p class="text-muted">
                            B.S. in Computer Science from the University of Tennessee at Knoxville
                        </p>

                        <hr>

                        <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                        <p class="text-muted">Malibu, California</p>

                        <hr>

                        <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                        <p>
                            <span class="label label-danger">UI Design</span>
                            <span class="label label-success">Coding</span>
                            <span class="label label-info">Javascript</span>
                            <span class="label label-warning">PHP</span>
                            <span class="label label-primary">Node.js</span>
                        </p>

                        <hr>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img id="image" src="http://127.0.0.1/cw_support/vendor/AdminLTE/img/user2-160x160.jpg" alt="Picture">
                            </div>
                            <div class="col-md-3">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->load->view('admin/footer'); ?>
<script src="<?=base_url('vendor/cropperjs/dist/cropper.min.js')?>"></script>
<script>
    function each(arr, callback) {
        var length = arr.length;
        var i;

        for (i = 0; i < length; i++) {
            callback.call(arr, arr[i], i, arr);
        }

        return arr;
    }

    window.addEventListener('DOMContentLoaded', function () {
        var image = document.querySelector('#image');
        var previews = document.querySelectorAll('.preview');
        var cropper = new Cropper(image, {
            ready: function () {
                var clone = this.cloneNode();

                clone.className = ''
                clone.style.cssText = (
                'display: block;' +
                'width: 100%;' +
                'min-width: 0;' +
                'min-height: 0;' +
                'max-width: none;' +
                'max-height: none;'
                );

                each(previews, function (elem) {
                    elem.appendChild(clone.cloneNode());
                });
            },

            crop: function (e) {
                var data = e.detail;
                var cropper = this.cropper;
                var imageData = cropper.getImageData();
                var previewAspectRatio = data.width / data.height;

                each(previews, function (elem) {
                    var previewImage = elem.getElementsByTagName('img').item(0);
                    var previewWidth = elem.offsetWidth;
                    var previewHeight = previewWidth / previewAspectRatio;
                    var imageScaledRatio = data.width / previewWidth;

                    elem.style.height = previewHeight + 'px';
                    previewImage.style.width = imageData.naturalWidth / imageScaledRatio + 'px';
                    previewImage.style.height = imageData.naturalHeight / imageScaledRatio + 'px';
                    previewImage.style.marginLeft = -data.x / imageScaledRatio + 'px';
                    previewImage.style.marginTop = -data.y / imageScaledRatio + 'px';
                });
            }
        });
    });
</script>
