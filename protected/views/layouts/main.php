<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\Menu;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>"/>
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>

<?php
if (Yii::$app->user->can('admin')) {
    $menuItems[] = ['label' => 'Пользователи', 'url' => ['/admin/user/index'],
        'items' => [
            ['label' => 'Регистрация', 'url' => ['/admin/user/reg']],
            ['label' => 'Список', 'url' => ['/admin/user/index']],
            ['label' => 'Группы', 'url' => ['/admin/auth/index']],
            ['label' => 'Разрешения', 'url' => ['/admin/auth/permissions']],
            ['label' => 'Заблокир. польз.', 'url' => ['/admin/user/index?status=0']],
        ]];
}

$menuItems[] = ['label' => 'Заявки жителей', 'url' => ['#'],
    'items' => [
        ['label' => 'Список заявок', 'url' => ['/orders/order/index']],
        ['label' => 'Закрытые заявки', 'url' => ['/orders/order/index?status=0']],
    ]
];

$menuItems[] = ['label' => 'Выйти  (' . Yii::$app->user->identity['username'] . ')',
    'url' => ['/site/logout'],
    'linkOptions' => ['data-metod' => 'post']
];
?>

<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <?php
            echo Menu::widget([
                'items' => $menuItems,
                'activateParents' => true,
                'activateItems' => true,
                'encodeLabels' => false,
                'options' => [
                    'class' => 'navmenu navmenu-default navmenu-fixed-left offcanvas'
                ]
            ]);
            ?>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?= $content; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
