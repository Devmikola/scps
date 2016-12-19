<?php

use yii\db\Migration;

class m161219_110104_create_table_test extends Migration
{
    public function safeUp()
    {
        $this->createTable('test', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'time' => $this->integer(),
            'questions_count' => $this->integer()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('test');
    }

}
