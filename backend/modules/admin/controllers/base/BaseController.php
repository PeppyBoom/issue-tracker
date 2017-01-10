<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.01.2017
 * Time: 15:08
 */

namespace backend\modules\admin\controllers\base;


use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public function init()
    {
        $this->layout = 'main';
        Yii::setAlias('@adminImg', str_replace(Yii::$app->basePath, 'backend', Yii::$app->assetManager->getPublishedPath('@vendor/almasaeed2010/adminlte/')));
        parent::init();
    }

}