<?php

/* @var $model \frontend\models\Issue */
/* @var $searchModel \frontend\models\search\IssueSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\widgets\StarRating;

/* @var $this yii\web\View */


$this->title = Yii::$app->name;

?>
<div class="site-index">
    <?php if (Yii::$app->user->isGuest): ?>
        <?= Yii::$app->session->setFlash('info', '<p>Не зарегистрированный пользователь может только просматривать таблицу</p> 
        <p>Для указания в таблице проблемы или способа ее решения войдите под аккаунтом: admin/000000</p>
        <p>Чтобы поставить оценку зарегистрируйтесь или войдите под аккаунтом: user/000000</p>
    ') ?>
    <?php endif; ?>
    <?php
    $before = (Yii::$app->user->can('changeNameAndSolution')) ?
        Html::a('<i class="glyphicon glyphicon-plus"></i> Добавить', 'site/add', ['class' => 'btn btn-success']) . ' ' .
        Html::submitButton('<i class="glyphicon glyphicon-remove"></i> Удалить', ['class' => 'btn btn-danger', 'formaction' => '/site/delete']) : false;
    $after = (Yii::$app->user->can('changeNameAndSolution') || Yii::$app->user->can('changeRating')) ? Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Сохранить', ['class' => 'btn btn-primary']) : false;
    $checkBoxColumn = false;
    if (Yii::$app->user->can('changeNameAndSolution') || Yii::$app->user->can('changeRating')) {
        $checkBoxColumn = '';
    }
    $form = ActiveForm::begin();
    $attributes = $searchModel->formAttributes;
    ?>
    <?=
    TabularForm::widget([
        'dataProvider' => $dataProvider,
        'form' => $form,
        'attributes' => $attributes,
        'gridSettings' => [
            'floatHeader' => true,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Таблица</h3>',
                'type' => GridView::TYPE_PRIMARY,
                'before' => $before,
                'after' => $after,
            ]
        ],
        'actionColumn' => false,
        'checkboxColumn' => $checkBoxColumn,
    ]);
    ?>
    <?php ActiveForm::end(); ?>

</div>
