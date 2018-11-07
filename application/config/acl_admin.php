<?php
if ( ! defined("BASEPATH")) exit("No direct script access allowed");
//遵循qeephp中的acl规则
$acl["all_controllers"] = array(
"allow"=>"ACL_HAS_ROLE",//表示所有拥有角色的用户
);
$acl=array (
  'sys_admin_config' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'sys_admin_log' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
      'export' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'sys_databases' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
      'download' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'sys_dept' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'sys_acl' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
      'acl' => 
      array (
        'allow' => 'super_admin',
      ),
      'acl_save' => 
      array (
        'allow' => 'super_admin',
      ),
      'acl_delete' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'sys_role' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'users' => 
      array (
        'allow' => 'super_admin',
      ),
      'tree' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'user' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'order' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'yigongjiaose,super_admin',
      ),
      'export' => 
      array (
        'allow' => 'yigongjiaose,super_admin',
      ),
    ),
  ),
  'rxysh' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'export' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'gzhft' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'export' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'qfxz' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'export' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'njchd' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'export' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'product_group' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
      'product_list_save' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'product' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'sys_user' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'dept' => 
      array (
        'allow' => 'super_admin',
      ),
      'user_dept_list' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'category' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
      'lists' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'push' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'save_news' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
      'send' => 
      array (
        'allow' => 'super_admin',
      ),
      'preview' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'message' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'yigongjiaose,super_admin',
      ),
      'save' => 
      array (
        'allow' => 'yigongjiaose,super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'yigongjiaose,super_admin',
      ),
      'send_email' => 
      array (
        'allow' => 'yigongjiaose,super_admin',
      ),
      'send_weixin' => 
      array (
        'allow' => 'yigongjiaose,super_admin',
      ),
    ),
  ),
  'volunteer' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'lists' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
      'product_list_save' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'back_paper' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'save' => 
      array (
        'allow' => 'super_admin',
      ),
      'preview' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'bill' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'export' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'material_news' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'news_lists' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
      'refresh' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
  'material_image' => 
  array (
    'allow' => 'ACL_HAS_ROLE',
    'actions' => 
    array (
      'index' => 
      array (
        'allow' => 'super_admin',
      ),
      'image_lists' => 
      array (
        'allow' => 'super_admin',
      ),
      'delete' => 
      array (
        'allow' => 'super_admin',
      ),
      'refresh' => 
      array (
        'allow' => 'super_admin',
      ),
    ),
  ),
);