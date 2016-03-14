<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $permissions app\models\AuthItem */

$this->title = 'Группа: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="auth-item-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <?php if ($model->name !== 'admin') :?>
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить ' . $model->name . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            'data',
        ],
    ]) ?>
    <h3>Разрешения для данной группы: </h3>
    <div>
        <ul>
            <?php
            if ($permissions):
                foreach ($permissions as $permission): ?>
                    <li>
                        <?php echo $permission->description; ?>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
            <?php if(!$permissions){ echo 'У данной группы нет разрешений';} ?>
        </ul>
    </div>
</div>
