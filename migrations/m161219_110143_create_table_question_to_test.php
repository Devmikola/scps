<?php

use yii\db\Migration;

class m161219_110143_create_table_question_to_test extends Migration
{
    public function safeUp()
    {
        $this->createTable('question_to_test', [
            'question_id' => $this->integer(),
            'test_id' => $this->integer()
        ]);

        $this->addPrimaryKey('question_to_test_pk', 'question_to_test', ['question_id', 'test_id']);
        $this->addForeignKey('fk-question_to_test-question_id', 'question_to_test', 'question_id', 'question', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_to_test-test_id', 'question_to_test', 'test_id', 'test', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('question_to_test');
    }
}
