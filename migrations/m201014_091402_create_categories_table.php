<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m201014_091402_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sequenced_number' => $this->integer(),
            'has_timer' => $this->string(),
            'countdown' => $this->string()->defaultValue(NULL),
            'test_tool' => $this->string()->defaultValue(NULL),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
