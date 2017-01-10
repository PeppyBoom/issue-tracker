<?php
/* @var $content string*/

use backend\modules\admin\assets\AdminAsset;
use yii\helpers\Html;

AdminAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang ="<?= Yii::$app->language?>">
<head>
    <meta charset="<?= Yii::$app->charset?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title)?></title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php $this->head()?>
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<?php $this->beginBody()?>
    <?= $content?>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
