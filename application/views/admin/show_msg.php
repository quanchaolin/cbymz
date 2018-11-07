<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="<?=base_url('public/plugins/layui/css/layui.css')?>" media="all" />
    <style type="text/css">

        ::selection {
            background-color: #E13300;
            color: white;
        }

        ::-moz-selection {
            background-color: #E13300;
            color: white;
        }

        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        #container {
            width:500px;
            margin: 10px auto;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }

        p {
            margin: 12px 15px 12px 15px;
        }
    </style>
</head>
<body>
<div id="container">
    <h1><?=$title ?></h1>
    <p><?=$message ?></p>
    <p align="right" style="margin: 20px; font-weight: bold;">
        <?php if ($url_forward) { ?>
            <a href="<?= $url_forward ?>" tabindex="0" class="layui-btn">
                确定 </a>
            <script type="text/javascript">
                function redirect(url, time) {
                    setTimeout("window.location='" + url + "'", time * 1000);
                }
                redirect('<?=$url_forward?>', <?=$second?>);
            </script>
        <?php }else{ ?>
            <a href="javascript:history.back();" class="layui-btn"> 返 回 </a>
        <?php } ?>
    </p>
</div>
</body>
</html>