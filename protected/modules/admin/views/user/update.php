<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Редактирование профиля пользователя: ';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_user, 'url' => ['view', 'id' => $model->id_user]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update">

    <h2><?php echo Html::encode($this->title); echo ' <i style=" color:green">' . $model->username . '</i>'; ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
