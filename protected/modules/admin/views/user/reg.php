<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model \app\modules\admin\models\RegForm */
/* @var $form ActiveForm */

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-signin'],
]); ?>
    <h3><?= Html::encode('Добавление пользователя') ?></h3>

<?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Только латинские буквы и цифры']) ?>
<?= $form->field($model, 'password') ?>

<?php $items = ArrayHelper::map($model->authitem, 'name', 'description');
$params = ['prompt' => 'Укажите группу']; ?>
<?= $form->field($model, 'authitem')->dropDownList($items, $params); ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

