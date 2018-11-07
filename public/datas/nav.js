var navs = [{
	"title": "信息管理",
	"icon": "fa-cubes",
	"spread": true,
	"children": [{
		"title": "回向文",
		"icon": "fa-handshake-o",
		"href": base_url+"admin/back_paper"
	}, {
		"title": "义工管理",
		"icon": "fa-users",
		"href": base_url+"admin/volunteer"
	}, {
		"title": "消息管理",
		"icon": "fa-envelope-o",
		"href": base_url+"admin/message"
	}, {
        "title": "消息推送",
        "icon": "fa-paper-plane",
        "href": base_url+"admin/push"
    },{
        "title": "分类管理",
        "icon": "fa-trophy ",
        "href": base_url+"admin/category"
    },{
        "title": "商品管理",
        "icon": "fa-shopping-bag",
        "href": base_url+"admin/product"
    },{
        "title": "商品分组",
        "icon": "fa-tags",
        "href": base_url+"admin/product_group"
    }]
}, {
	"title": "心愿单",
	"icon": "fa-heart",
	"spread": false,
	"children": [{
        "title": "心愿单",
        "icon": "fa-heart-o",
        "href": base_url+"admin/order"
    },{
		"title": "日行一善",
		"icon": "fa-calendar",
		"href": base_url+"admin/rxysh"
	}, {
		"title": "广种福田",
		"icon": "fa-navicon",
		"href": base_url+"admin/gzhft"
	}, {
		"title": "祈福消灾",
		"icon": "&#xe62a;",
		"href": base_url+"admin/qfxz"
	}, {
		"title": "念经超度",
		"icon": "fa-book",
		"href": base_url+"admin/njchd"
	}]
}, {
	"title": "微信管理",
	"icon": "fa-weixin",
	"spread": false,
	"children": [{
		"title": "用户管理",
		"icon": "fa-user-o",
		"href": base_url+"admin/user"
	},{
        "title": "图片管理",
        "icon": "fa-file-image-o",
        "href": base_url+"admin/material_image"
    }, {
        "title": "视频管理",
        "icon": "fa-file-video-o",
        "href": base_url+"admin/material_video"
    }, {
        "title": "语音管理",
        "icon": "fa-file-audio-o",
        "href": base_url+"admin/material_voice"
    }, {
        "title": "图文管理",
        "icon": "fa-newspaper-o",
        "href": base_url+"admin/material_news"
    }]
}, {
	"title": "系统管理",
	"icon": "fa-stop-circle",
	"href": "#",
	"spread": false,
	"children": [{
		"title": "账号管理",
		"icon": "fa-github",
		"href": base_url+"admin/admin/index/"
	},{
        "title": "角色管理",
        "icon": "fa-github",
        "href": base_url+"admin/role/index/"
    },{
        "title": "权限管理",
        "icon": "fa-lock",
        "href": base_url+"admin/admin_privilege/index/"
    },{
        "title": "系统配置",
        "icon": "fa-cogs",
        "href": base_url+"admin/admin_config/index/"
    },{
        "title": "登录日志",
        "icon": "fa-list",
        "href": base_url+"admin/log_admin/index/"
    },{
        "title": "数据备份",
        "icon": "fa-database",
        "href": base_url+"admin/databases/"
    }
    ]
}];