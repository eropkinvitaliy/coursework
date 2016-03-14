<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status */

if (empty($status)) {
    $this->title = Yii::t('app', 'Список заблокированных пользователей');
} else {
    $this->title = Yii::t('app', 'Список пользователей');
}
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
    <div class="users-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?php if (!empty($status)): ?>
                <?= Html::a(Yii::t('app', 'Добавить нового пользователя'), ['reg'], ['class' => 'btn btn-success']) ?>

        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username',
                [
                    'label' => 'Группа',
                    'value' => 'role.description',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Заблокировать'),
                                'data-confirm' => Yii::t('yii', 'Вы действительно хотите заблокировать пользователя?'),
                                'data-method' => 'post',
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php else: ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username',
                [
                    'label' => 'Группа',
                    'value' => 'role.description',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Восстановить', $url, [
                                'title' => Yii::t('yii', 'Восстановить'),
                                'data-confirm' => Yii::t('yii', 'Вы действительно хотите восстановить пользователя?'),
                                'data-method' => 'post',
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php endif ?>
    </div>
<?php Pjax::end(); ?>