<?php

use yii\db\Migration;

class m161219_110044_create_table_question extends Migration
{
    public function safeUp()
    {
        $this->createTable('question', [
            'id' => $this->primaryKey(),
            'question' => $this->text(),
            'answer' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('question');
    }

}
