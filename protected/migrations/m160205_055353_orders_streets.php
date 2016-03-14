<?php

use yii\db\Schema;
use yii\db\Migration;

class m160205_055353_orders_streets extends Migration
{

    public function up()
    {
        $tableOptions = null;
        $this->createTable('{{%streets}}', [
            'id_street' => $this->primaryKey(),
            'namestreet' => $this->string()->notNull(),
        ], $tableOptions);

        $lines = file(__DIR__ . '/streetstambov.txt');
        foreach ($lines as $linenum => $namestreet) {
            $this->insert('{{%streets}}', [
                'namestreet' => $namestreet,
            ]);
        };

        $this->createTable('{{%order}}', [
            'id_order' => $this->primaryKey(),
            'familiya' => $this->string(64)->notNull(),
            'name' => $this->string(24),
            'otchestvo' => $this->string(24),
            'street_id' => $this->integer(4)->notNull(),
            'home' => $this->string(8)->notNull(),
            'apartment' => $this->string(8),
            'fone' => $this->string(32)->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'user' => $this->integer(4),
            'user_updated' => $this->integer(4),
            'status' => $this->boolean()->notNull()->defaultValue(true),
        ], $tableOptions);
        $this->createIndex('indx_street', '{{%order}}', 'street_id');
        $this->createIndex('indx_home', '{{%order}}', 'home');
        $this->addForeignKey('street', '{{%order}}','street_id', '{{%streets}}', 'id_street');
        $this->addForeignKey('username', '{{%order}}','user', '{{%user}}', 'id_user');

    }

    public function down()
    {
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%streets}}');
    }

}
