<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%exam_participants}}`.
 */
class m210714_143255_add_queue_status_column_to_exam_participants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exam_participants}}', 'queue_status', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%exam_participants}}', 'queue_status');
    }
}
