<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Заявки от жителей города');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить новую заявку'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'street.namestreet',
            'home',
            'countorders',
            [
                'label' => '',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(
                        'Просмотр заявок дома № ' . $data->home,
                        '/orders/order/home?street=' . $data->street_id . '&home=' . $data->home,
                        [
                            'title' => 'Посмотреть заявки жителей этого дома',
                            'target' => '_blank'
                        ]
                    );
                }
            ],
        ],
    ]); ?>



</div>
<?php Pjax::end(); ?>