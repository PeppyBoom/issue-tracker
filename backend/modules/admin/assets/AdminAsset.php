<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.01.2017
 * Time: 15:19
 */

namespace backend\modules\admin\assets;


use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = "@vendor/almasaeed2010/adminlte/";
    public $css = [
        "bootstrap/css/bootstrap.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css",
        "dist/css/AdminLTE.min.css",
        "dist/css/skins/_all-skins.min.css",
    ];
    public $js = [
        "plugins/jQuery/jquery-2.2.3.min.js",
        "bootstrap/js/bootstrap.min.js",
        "plugins/slimScroll/jquery.slimscroll.min.js",
        "plugins/fastclick/fastclick.js",
        "dist/js/app.min.js",
        "dist/js/demo.js",
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}