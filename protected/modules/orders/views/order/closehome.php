<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\modules\orders\models\Order */

$this->title = Yii::t('app', 'Закрытые заявки от жителей города, проживающих: ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <p style="font-size: medium"><b><?= Html::encode($model->street->namestreet . ', дом ' . $model->home) ?></b></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'familiya',
            'apartment',
            'fone',
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd.MM.Y (HH:mm) '],
                'options' => ['width' => '200']
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Закрыта',
                'format' =>  ['date', 'dd.MM.Y (HH:mm) '],
                'options' => ['width' => '200']
            ],
            [
                'label' => 'Закрыл',
                'value' => 'userclosed.username',
            ],
            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>

</div>
