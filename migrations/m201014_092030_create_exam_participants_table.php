<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exam_participants}}`.
 */
class m201014_092030_create_exam_participants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%exam_participants}}', [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer(),
            'participant_id' => $this->integer(),
            'status' => $this->string(),
        ]);

        $this->createIndex(
            'idx-exam_participants-participant_id',
            'exam_participants',
            'participant_id'
        );

        $this->addForeignKey(
            'fk-exam_participants-participant_id',
            'exam_participants',
            'participant_id',
            'participants',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-exam_participants-exam_id',
            'exam_participants',
            'exam_id'
        );

        $this->addForeignKey(
            'fk-exam_participants-exam_id',
            'exam_participants',
            'exam_id',
            'exams',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%exam_participants}}');
    }
}
