<?php
// +----------------------------------------------------------------------
// | Sphynx递归无限级分类多种情况
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://www.sunnyos.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Sphynx <admin@sunnyos.com> QQ327388905
// +----------------------------------------------------------------------
/*
*+----------------------------------------------------------------------
*	递归无限级分类多种情况
*+----------------------------------------------------------------------
*/
class Cate{
    /*
     * 适合后台列表遍历的格式
     * @param $cate	 	要处理的分类数组
     * @param $html		二级分类分隔符
     * @param $pid		上级分类id
     * @param $pad		分隔符数量
     */
    public static function level($cate,$html='----',$pid=0,$pad=0){
        $arr = array();
        foreach ($cate as $key => $value) {
            if($value['pid']==$pid){
                $value['pad'] = $pad+1;
                $value['html'] = str_repeat($html,$pad);
                $arr[] = $value;
                $arr = array_merge($arr,self::level($cate,$html,$value['id'],$pad+1));
            }
        }
        return $arr;
    }

    /*
     * 多维数组遍历，适合用于顶部菜单和列表
     * @param $cate	 	要处理的分类数组
     * @param $name		顶级分类之后的二级分类下标
     * @param $pid		上级分类id
     */
    public static function layer($cate,$name = 'child',$pid = 0){
        $arr = array();
        foreach ($cate as $v) {
            if($v['pid']==$pid){
                $v[$name] =  self::layer($cate,$name,$v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }

    /*
     * 通过子分类查找父级分类
     * @param $cate	 	要处理的分类数组
     * @param $id		子类id
     */
    public static function getParents($cate,$id){
        $arr = array();
        foreach ($cate as $key => $value) {
            if($value['id']==$id){
                $arr[] = $value;
                $arr = array_merge(self::getParents($cate,$value['pid']),$arr);
            }
        }
        return $arr;
    }

    /*
     * 通过父类查找子类分类
     * @param $cate	 	要处理的分类数组
     * @param $id		父类id
     */
    public static function getFind($cate,$id){
        $arr = array();
        foreach ($cate as $key => $value) {
            if($value['pid']==$id){
                $arr[] = $value;
                $arr = array_merge($arr,self::getFind($cate,$value['id']));
            }
        }
        return $arr;
    }

}