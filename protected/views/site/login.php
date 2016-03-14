<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\Users */
/* @var $form ActiveForm */
/* @var $model app\models\LoginForm */


$form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-signin'],
    ]
);
if (Yii::$app->user->isGuest) {
    echo $form->field($model, 'username');
    echo $form->field($model, 'password')->passwordInput();
    echo $form->field($model, 'rememberMe')->checkbox();
}
?>
<div class="form-group">
    <?php
    if (Yii::$app->user->isGuest) {
        echo Html::submitButton('Войти', ['class' => 'btn btn-primary']);
    }
    ?>
</div>
<?php ActiveForm::end(); ?>

