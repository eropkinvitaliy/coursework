<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-lg-8">
    <div class="auth-item-form">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Название латинскими буквами']) ?>

<?= $form->field($model, 'description')->textInput() ?>

<?php echo $form->field($model, 'data')->textarea(['rows' => 2])?>

<?= $form->field($model, 'type')->hiddenInput(['value' => 1])->label(false); ?>

<?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
<?php if (!$model->isNewRecord): ?>
    <h3>Разрешения для данной группы: </h3>
    <h4><?php if (!$model->permissions) {
            echo '  -- разрешений нет';
        }; ?></h4>
    <div>
        <ul>
            <?php
            foreach ($model->permissions as $permission): ?>
                <li>
                    <?php echo $permission->description; ?>
                    <a href="del-child-role?id=<?= $permission->name; ?>" title="Удалить"
                       aria-label="Удалить"
                       data-confirm=<?php echo '"' . 'Вы уверены, что хотите удалить разрешение : ' . $permission->description . ' "'; ?>
                       data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>

                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php echo '<br>'; ?>
    <div class="form-group">
        <?= Html::a('Добавить разрешения', ['add-permissions', 'id' => $model->name], ['class' => 'btn btn-success']) ?>
    </div>
<?php endif ?>
<?php ActiveForm::end(); ?>
    </div>
