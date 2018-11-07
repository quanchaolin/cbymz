<?php
$role_id=$this->admin['role_id'];
$role_menu=get_cache('role_menu_'.$role_id);
?>
<script>
    (function(){
        var role_menu=<?=$role_menu?>;
        var html_str='';
        var full_url='<?=site_url('admin/')?>';
        create_menu(role_menu);
        function create_menu(menu_list)
        {
            if(menu_list && menu_list.length>0)
            {
                $(menu_list).each(function(i,menu){
                    var url='#';
                    var active='';
                    var active_flag=check_active(menu.url);
                    if(active_flag==true)
                    {
                        active='active';
                    }
                    if(menu.url!='undefined')
                    {
                        url=full_url+menu.url;
                    }
                    if(menu.child && menu.child.length > 0)
                    {
                        html_str+='<li class="treeview"> <a href="#"><i class="fa fa-dashboard"></i> <span>'+menu.name+'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a><ul class="treeview-menu">';
                        create_menu(menu.child);
                        html_str+='</ul></li>';
                    }
                    else
                    {
                        html_str+='<li class="'+active+'"> <a href="'+url+'"> <i class="fa fa-circle-o"></i> <span>'+menu.name+'</span> </a> </li>';
                    }
                });
            }
            $("#showMenu").html(html_str);
        }
        $(".treeview").each(function(i){
            var obj=$(this);
            var active=obj.find('.active');
            if(active.length>0)
            {
                obj.addClass('active');
                obj.addClass('menu-open');
            }
        });
        function check_active(url)
        {
            var flag=false;
            if(url=='' || url==undefined)
            {
                return flag;
            }
            var control='<?=$this->control?>';
            var type='<?=$this->type?>';
            var url_arr=url.split('/');
            var url_arr2= url.split('?');
            var url_control=url_arr[0];
            var url_method=url_arr[1];
            if(control==url_control && type=='')
            {
                flag=true;
            }
            else if(control==url_control && type==url_method)
            {
                flag=true;
            }
            else if(control==url_control && $.inArray('type='+type,url_arr2)!=-1)
            {
                flag=true;
            }
            return flag;
        }
    })();
</script>