<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exam_questions}}`.
 */
class m201014_091947_create_exam_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%exam_questions}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'exam_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-exam_questions-post_id',
            'exam_questions',
            'post_id'
        );

        $this->addForeignKey(
            'fk-exam_questions-post_id',
            'exam_questions',
            'post_id',
            'posts',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-exam_questions-exam_id',
            'exam_questions',
            'exam_id'
        );

        $this->addForeignKey(
            'fk-exam_questions-exam_id',
            'exam_questions',
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
        $this->dropTable('{{%exam_questions}}');
    }
}
