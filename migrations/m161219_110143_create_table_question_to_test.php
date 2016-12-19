<?php

use yii\db\Migration;

class m161219_110143_create_table_question_to_test extends Migration
{
    public function safeUp()
    {
        $this->createTable('question_to_answer', [
            'question_id' => $this->integer(),
            'test_id' => $this->integer()
        ]);

        $this->addForeignKey('fk-question_to_answer-question_id', 'question_to_answer', 'question_id', 'question', 'id', null, 'CASCADE');
        $this->addForeignKey('fk-question_to_answer-test_id', 'question_to_answer', 'test_id', 'test', 'id', null, 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('question_to_answer');
    }
}
