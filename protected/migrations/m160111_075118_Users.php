<?php

use yii\db\Schema;
use yii\db\Migration;
use yii\rbac\Role;

class m160111_075118_Users extends Migration
{

    public function up()
    {
        $tableOptions = null;
        $this->createTable('{{%user}}', [
            'id_user' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(64) NOT NULL',
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT TRUE',
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'username' => 'superuser',
            'password_hash' => '$2y$13$nWr/ahliQJjXmPlM2vdT4.2410Pn97j8s0PCS3rk6bG63LENTWdsC',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => 1,
        ]);

        $auth = Yii::$app->authManager;

        // добавляем разрешение "fullAccess"
        $fullAccess = $auth->createPermission('fullAccess');
        $fullAccess->description = 'Полный доступ к ресурсам';
        $auth->add($fullAccess);

        // добавляем роль "superadmin" и даём роли разрешение "fullAccess"
        $superadmin = $auth->createRole('admin');
        $superadmin->description = 'Администратор';
        $superadmin->data = 'Администратор всего содержимого данной программы, с неограниченным доступом';
        $auth->add($superadmin);
        $auth->addChild($superadmin, $fullAccess);

        // Назначение роли пользователю superadmin
        $auth->assign($superadmin, 1);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $auth = Yii::$app->authManager;
        $auth->removeAll();

    }

}
