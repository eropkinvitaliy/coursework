<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\modules\orders\models\Order */

$this->title = Yii::t('app', 'Заявки от жителей города, проживающих: ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <p style="font-size: medium"><b><?= Html::encode($model->street->namestreet . ', дом ' . $model->home) ?></b></p>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить новую заявку'), ['create'], ['class' => 'btn-sm btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_order',
            'familiya',
            'apartment',
            'fone',
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd.MM.Y (HH:mm) '],
                'options' => ['width' => '200']
            ],
            [
                'label' => 'Создал',
                'value' => 'username.username',
            ],
            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>

</div>
