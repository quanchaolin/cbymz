<?php

include 'Content.php';

/**
 * 文件上传管理控制器
 * @author qcl 2016-005-04
 *
 */
include APPPATH."libraries/Uploader.class.php";
class File extends Content {

    /**
     * 构造器
     */
    function __construct ()
    {
        $this->name = "文件管理";
        $this->control = 'file';
        $this->list_view = 'file_list'; // 列表页
        $this->add_view = 'file_add'; // 添加页
        parent::__construct();
        $_SESSION['nav'] = 1;
        $this->baseurl = site_url('admin/file/');
        $this->load->model('admin/file_model', 'model');
    }
    public function media_upload()
    {
        /* 上传视频配置 */
        $video_config=array(
            "mediaActionName"=> "uploadmedia", /* 执行上传视频的action名称 */
            "mediaFieldName"=> "file", /* 提交的视频表单名称 */
            "mediaPathFormat"=>"uploads/media/{yyyy}{mm}{dd}/{time}_{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "mediaUrlPrefix"=> "", /* 视频访问路径前缀 */
            "mediaMaxSize"=> 20971520, /* 上传大小限制，单位B，默认20MB */
            "mediaAllowFiles"=> array(
                ".jpg",".jpeg",".png",".gif",".amr",".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
                ".ogg", ".ogv",".wma", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"), /* 上传视频格式显示 */
        );
        $config = array(
            "pathFormat" => $video_config['mediaPathFormat'],
            "maxSize" => $video_config['mediaMaxSize'],
            "allowFiles" => $video_config['mediaAllowFiles']
        );
        $fieldName = $video_config['mediaFieldName'];
        $type=$video_config['mediaActionName'];
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $type);
        exit(json_encode($up->getFileInfo()));
    }
    public function video_upload()
    {
        /* 上传视频配置 */
        $video_config=array(
            "videoActionName"=> "uploadvideo", /* 执行上传视频的action名称 */
            "videoFieldName"=> "file", /* 提交的视频表单名称 */
            "videoPathFormat"=>"uploads/video/{yyyy}{mm}{dd}/{time}_{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "videoUrlPrefix"=> "", /* 视频访问路径前缀 */
            "videoMaxSize"=> 10240000000, /* 上传大小限制，单位B，默认100MB */
            "videoAllowFiles"=> array(
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"), /* 上传视频格式显示 */
        );
        $config = array(
            "pathFormat" => $video_config['videoPathFormat'],
            "maxSize" => $video_config['videoMaxSize'],
            "allowFiles" => $video_config['videoAllowFiles']
        );
        $fieldName = $video_config['videoFieldName'];
        $type=$video_config['videoActionName'];
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $type);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        /* 返回数据 */
        exit(json_encode($up->getFileInfo()));
    }
    public function voice_upload()
    {
        /* 上传视频配置 */
        $voice_config=array(
            "voiceActionName"=> "uploadvoice", /* 执行上传视频的action名称 */
            "voiceFieldName"=> "file", /* 提交的视频表单名称 */
            "voicePathFormat"=>"uploads/voice/{yyyy}{mm}{dd}/{time}_{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "voiceUrlPrefix"=> "", /* 视频访问路径前缀 */
            "voiceMaxSize"=> 1073741824, /* 上传大小限制，单位B，默认30MB */
            "voiceAllowFiles"=> array(".mp3", ".wma", ".wav", ".amr"), /* 上传视频格式显示 */
        );
        $config = array(
            "pathFormat" => $voice_config['voicePathFormat'],
            "maxSize" => $voice_config['voiceMaxSize'],
            "allowFiles" => $voice_config['voiceAllowFiles']
        );
        $fieldName = $voice_config['voiceFieldName'];
        $type=$voice_config['voiceActionName'];
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $type);
        exit(json_encode($up->getFileInfo()));
    }
    public function image_upload()
    {
        /* 上传视频配置 */
        $image_config=array(
            "imageActionName"=> "uploadimage", /* 执行上传视频的action名称 */
            "imageFieldName"=> "file", /* 提交的视频表单名称 */
            "imagePathFormat"=>"uploads/image/{yyyy}{mm}{dd}/{time}_{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "imageUrlPrefix"=> "", /* 视频访问路径前缀 */
            "imageMaxSize"=> 5242880, /* 上传大小限制，单位B，默认5MB */
            "imageAllowFiles"=> array(".bmp",".png", ".jpg", ".jpeg", ".gif"), /* 上传视频格式显示 */
        );
        $config = array(
            "pathFormat" => $image_config['imagePathFormat'],
            "maxSize" => $image_config['imageMaxSize'],
            "allowFiles" => $image_config['imageAllowFiles']
        );
        $fieldName = $image_config['imageFieldName'];
        $type=$image_config['imageActionName'];
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $type);
        exit(json_encode($up->getFileInfo()));
    }
    public function excel_upload()
    {
        /* 上传视频配置 */
        $excel_config=array(
            "excelActionName"=> "uploadexcel", /* 执行上传视频的action名称 */
            "excelFieldName"=> "file", /* 提交的视频表单名称 */
            "excelPathFormat"=>"uploads/excel/{yyyy}{mm}{dd}/{time}_{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "excelUrlPrefix"=> "", /* 视频访问路径前缀 */
            "excelMaxSize"=> 5242880, /* 上传大小限制，单位B，默认5MB */
            "excelAllowFiles"=> array(".xls",".xlsx"), /* 上传视频格式显示 */
        );
        $config = array(
            "pathFormat" => $excel_config['excelPathFormat'],
            "maxSize" => $excel_config['excelMaxSize'],
            "allowFiles" => $excel_config['excelAllowFiles']
        );
        $fieldName = $excel_config['excelFieldName'];
        $type=$excel_config['excelActionName'];
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $type);
        exit(json_encode($up->getFileInfo()));
    }
    public function upload()
    {
        /* 上传视频配置 */
        $excel_config=array(
            "ActionName"=> "upload", /* 执行上传视频的action名称 */
            "FieldName"=> "file", /* 提交的视频表单名称 */
            "PathFormat"=>"uploads/file/{yyyy}{mm}{dd}/{time}_{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "UrlPrefix"=> "", /* 视频访问路径前缀 */
            "MaxSize"=> 5242880, /* 上传大小限制，单位B，默认5MB */
            "AllowFiles"=> array(".png", ".jpg", ".jpeg", ".gif", ".bmp",
                ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
                ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
                ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
                ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"), /* 上传视频格式显示 */
        );
        $config = array(
            "pathFormat" => $excel_config['PathFormat'],
            "maxSize" => $excel_config['MaxSize'],
            "allowFiles" => $excel_config['AllowFiles']
        );
        $fieldName = $excel_config['FieldName'];
        $type=$excel_config['ActionName'];
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $type);
        exit(json_encode($up->getFileInfo()));
    }
}