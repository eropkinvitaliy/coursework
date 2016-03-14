<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\orders\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">
<div class="col-lg-6">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'familiya')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'otchestvo')->textInput(['maxlength' => true]) ?>

    <?php
    $items = ArrayHelper::map($model->streets, 'id_street', 'namestreet');
    $params = ['prompt' => 'Выберите улицу']; ?>
    <?= $form->field($model, 'street_id')->dropDownList($items, $params); ?>

    <?= $form->field($model, 'home')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apartment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать') : Yii::t('app', 'Изменить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
