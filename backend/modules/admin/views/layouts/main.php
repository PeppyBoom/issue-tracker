<?php
/* @var $content string*/

use yii\widgets\Breadcrumbs;
?>

<?php $this->beginContent('@backend/modules/admin/views/layouts/base.php')?>
<!-- Site wrapper -->
<div class="wrapper">
    <?= $this->render('header/header')?>
    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <?= $this->render('sidebar/main-sidebar')?>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?= $this->render('content/header')?>

        <!-- Main content -->
        <?= $this->render('content/main', ['content' => $content])?>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?= $this->render('footer/footer')?>

    <!-- Control Sidebar -->
    <?= $this->render('sidebar/control-sidebar')?>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<?php $this->endContent()?>
