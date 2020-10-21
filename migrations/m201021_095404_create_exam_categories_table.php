<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exam_categories}}`.
 */
class m201021_095404_create_exam_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%exam_categories}}', [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer(),
            'category_id' => $this->integer(),
            'participant_id' => $this->integer(),
            'time_left' => $this->integer(),
            'created_at' => $this->timestamp(),
        ]);

        $this->createIndex(
            'idx-exam_categories-exam_id',
            'exam_categories',
            'exam_id'
        );

        $this->addForeignKey(
            'fk-exam_categories-exam_id',
            'exam_categories',
            'exam_id',
            'exams',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-exam_categories-category_id',
            'exam_categories',
            'category_id'
        );

        $this->addForeignKey(
            'fk-exam_categories-category_id',
            'exam_categories',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-exam_categories-participant_id',
            'exam_categories',
            'participant_id'
        );

        $this->addForeignKey(
            'fk-exam_categories-participant_id',
            'exam_categories',
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
        $this->dropTable('{{%exam_categories}}');
    }
}
