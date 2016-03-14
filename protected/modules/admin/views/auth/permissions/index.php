<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $permissions */

$this->title = 'Разрешения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новое разрешение', ['create?type=2'], ['class' => 'btn btn-success']) ?>
    </p>

    <div id="w0" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th style="width: 5%"> №</th>
                <th style="width: 15%">Разрешение</th>
                <th style="width: 15%">Описание разрешения</th>
                <th style="width: 8%">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $n = 0;
            foreach ($permissions as $item): ?>
                <tr data-key=<?= $item->name; ?>>
                    <td><?= ++$n; ?></td>
                    <td><?= $item->name; ?></td>
                    <td><?= $item->description; ?></td>
                    <td>
                        <?php if ($item->name !== 'fullAccess'):?>
                            <a href="view?type=<?= $item->type; ?>&id=<?= $item->name; ?>" title="Просмотр" aria-label="Просмотр"
                               data-pjax="0">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </a>
                            <a href="update?type=<?= $item->type; ?>&id=<?= $item->name; ?>" title="Редактировать"
                               aria-label="Редактировать" data-pjax="0"><span
                                    class="glyphicon glyphicon-pencil"></span></a>

                            <a href="<?= Url::to(['del-permission', 'id' => $item->name])?>"
                               data-method="post" aria-label="Удалить" title="Удалить"
                               data-confirm="Вы уверены, что хотите удалить разрешение <?php echo $item->name ?> ?"
                               data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>

                        <?php else: ?>
                            <a href="view?type=<?= $item->type; ?>&id=<?= $item->name; ?>" title="Просмотр" aria-label="Просмотр"
                               data-pjax="0">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>
