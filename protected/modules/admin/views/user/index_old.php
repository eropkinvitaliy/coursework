<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model [] */

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Регистрация нового пользователя', ['reg'], ['class' => 'btn btn-success']) ?>
    </p>

    <div id="w0" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th style="width: 5%"> №</th>
                <th style="width: 15%">Пользователь</th>
                <th style="width: 15%">Группа</th>
                <th style="width: 42%">Описание группы</th>
                <th style="width: 8%">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $n = 0;
            foreach ($model as $item) {
                ?>
                <tr data-key=<?= $item['username']; ?>>
                    <td><?= ++$n; ?></td>
                    <td><?= $item['username']; ?></td>
                    <td><?= $item['item_name']; ?></td>
                    <td><?= $item['description']; ?></td>
                    <td>
                        <?php if ($item['status']): ?>
                            <a href="view?id=<?= $item['id_user']; ?>" title="Просмотр" aria-label="Просмотр"
                               data-pjax="0">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </a>

                            <?php if ($item['username'] !== 'superuser'): ?>
                                <a href="update?id=<?= $item['id_user']; ?>" title="Редактировать"
                                   aria-label="Редактировать" data-pjax="0"><span
                                        class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <a href="<?= Url::to(['delete', 'id' => $item['id_user']])?>"
                                   data-method="post" aria-label="Удалить" title="Удалить"
                                   data-confirm="Вы уверены, что хотите удалить пользователя <?php echo $item['username'] ?> ?"
                                   data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
                            <?php endif ?>
                        <?php else: ?>
                            <a href="<?= Url::to(['delete', 'id' => $item['id_user']])?>"
                               data-method="post" aria-label="Восстановить" title="Восстановить"
                               data-confirm="Восстановить пользователя <?php echo $item['username'] ?> ?"
                               data-pjax="0"><span class="glyphicon glyphicon-heart"></span></a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
