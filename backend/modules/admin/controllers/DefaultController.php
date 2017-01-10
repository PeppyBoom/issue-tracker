<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.01.2017
 * Time: 15:09
 */

namespace backend\modules\admin\controllers;


use backend\modules\admin\controllers\base\BaseController;

class DefaultController extends BaseController
{
    public function actionIndex()
    {
        $this->view->title = 'Административная панель';
        $this->view->params['breadcrumbs'][] = 'admin';

        return $this->render('index');
    }
}