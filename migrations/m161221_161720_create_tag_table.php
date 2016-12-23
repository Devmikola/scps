<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags`.
 */
class m161221_161720_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('tag');
    }
}
