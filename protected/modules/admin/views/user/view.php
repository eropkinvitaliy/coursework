<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $role */

$this->title = ' <b style=" color:green">' . $model->username . '</b>';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <h1><?php echo $this->title ?></h1>
<?php if ($model->username !== 'superuser'): ?>
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id_user], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id_user], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить пользователя' . $model->username .'?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php endif ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            [
                'label' => 'Группа',
                'value' => $role,
            ],
            'status:boolean',
        ],
    ]) ?>

</div>
