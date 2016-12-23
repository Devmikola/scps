<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags_to_questions`.
 */
class m161221_161734_create_tag_to_question_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('tag_to_question', [
            'tag_id' => $this->integer(),
            'question_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('tag_to_question_pk', 'tag_to_question', ['tag_id', 'question_id']);
        $this->addForeignKey('fk-tag_to_question-tag_id', 'tag_to_question', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-tag_to_question-question_id', 'tag_to_question', 'question_id', 'question', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('tag_to_question');
    }
}
