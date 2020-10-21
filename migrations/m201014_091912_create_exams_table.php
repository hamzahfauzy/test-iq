<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exams}}`.
 */
class m201014_091912_create_exams_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%exams}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'start_time' => $this->timestamp(),
            'end_time' => $this->timestamp(),
            'created_at' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%exams}}');
    }
}
