<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $permissions \app\models\AuthItem */

$this->title = 'Выберите разрешения для группы: ' . ' ' . $model->name;
?>

<div class="auth-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="auth-group-form">

        <?php $form = ActiveForm::begin([
            'id' => 'permission-form',
            'options' => ['class' => 'form-horizontal'],
        ]);
        ?>
        <label><input type="hidden" name="group" value="<?= $model->name ?>"></label>
        <?php
        if (!empty($permissions)):
            foreach ($permissions as $permission) {
                if ($permission->name == 'fullAccess') continue; ?>
                <div id="authrule-rule_description">
                    <label><input type="checkbox" name="permission[<?php echo $permission->name; ?> ]" value="1">
                        <?php echo $permission->description; ?>
                    </label></div>
                <?php
            }
        endif;
        ?>
        <p></p>

        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Отменить', ['update', 'id' => $model->name], ['class' => 'btn btn-danger']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
