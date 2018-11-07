<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img onclick="javascript:window.location.href='<?=site_url('admin/profile/index/')?>'" src="<?=$this->admin['head_img_url']?>" class="img-circle" style="cursor: pointer" alt="用户头像">
            </div>
            <div class="pull-left info">
                <p><?=$this->admin['true_name']?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree" id="showMenu">
            <li class="header">主导航</li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>