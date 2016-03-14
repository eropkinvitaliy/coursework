<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\orders\models\Order */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Orders',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_order]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>