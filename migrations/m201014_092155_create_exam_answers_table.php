<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exam_answers}}`.
 */
class m201014_092155_create_exam_answers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%exam_answers}}', [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer(),
            'question_id' => $this->integer(),
            'answer_id' => $this->integer(),
            'answer_content' => $this->string(),
            'score' => $this->string(),
            'participant_id' => $this->integer(),
            'created_at' => $this->timestamp(),
        ]);

        $this->createIndex(
            'idx-exam_answers-exam_id',
            'exam_answers',
            'exam_id'
        );

        $this->addForeignKey(
            'fk-exam_answers-exam_id',
            'exam_answers',
            'exam_id',
            'exams',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-exam_answers-question_id',
            'exam_answers',
            'question_id'
        );

        $this->addForeignKey(
            'fk-exam_answers-question_id',
            'exam_answers',
            'question_id',
            'posts',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-exam_answers-answer_id',
            'exam_answers',
            'answer_id'
        );

        $this->addForeignKey(
            'fk-exam_answers-answer_id',
            'exam_answers',
            'answer_id',
            'posts',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-exam_answers-participant_id',
            'exam_answers',
            'participant_id'
        );

        $this->addForeignKey(
            'fk-exam_answers-participant_id',
            'exam_answers',
            'participant_id',
            'participants',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%exam_answers}}');
    }
}
