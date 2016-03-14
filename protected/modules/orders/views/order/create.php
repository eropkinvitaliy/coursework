<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\orders\models\Order */

$this->title = Yii::t('app', 'Добавление заявки от жителей');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
