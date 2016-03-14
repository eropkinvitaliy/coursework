<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\orders\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id_order], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Закрыть'), ['delete', 'id' => $model->id_order], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы действительно хотите закрыть заявку?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'familiya',
            'name',
            'otchestvo',
            'street_id',
            'home',
            'apartment',
            'fone',
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd.MM.Y (HH:mm) '],
                'options' => ['width' => '200']
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'dd.MM.Y (HH:mm) '],
                'options' => ['width' => '200']
            ],
            [
                'attribute' => 'user',
                'value' => $model->usercreated->username,
            ],
            [
                'attribute' => 'user_updated',
                'value' => $model->userupdated->username,
            ],
            'status:boolean',
        ],
    ]) ?>

</div>
