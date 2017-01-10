<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.01.2017
 * Time: 14:13
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class StarRatingAsset extends AssetBundle
{
    public $sourcePath = '@vendor/kartik-v/bootstrap-star-rating/';
    public $css = [
        "http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css",
        "css/star-rating.css",
        "themes/krajee-svg/theme.css",

    ];
    public $js = [
//        "//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js",
        "js/star-rating.js",
        "themes/krajee-svg/theme.js",
        "js/locales/ru.js"
    ];
}