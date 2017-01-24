<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170124_084645_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(20),
            'password_hash' => $this->string(60),
            'auth_key' => $this->string(32),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}



