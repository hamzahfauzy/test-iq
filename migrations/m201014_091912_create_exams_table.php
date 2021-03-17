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
            'start_time' => 'timestamp NULL', //$this->timestamp(),
            'end_time' => 'timestamp NULL', //$this->timestamp(),
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP', //$this->timestamp(),
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
