<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Закрытые заявки');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
                        '/order/order/home?street=' . $data->street_id . '&home=' . $data->home . '&status=0',
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