<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%import_exam_files}}`.
 */
class m210609_093234_create_import_exam_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%import_exam_files}}', [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer(),
            'file_path' => $this->string(),
        ]);

        $this->createIndex(
            'idx-import_exam_files-exam_id',
            'import_exam_files',
            'exam_id'
        );

        $this->addForeignKey(
            'fk-import_exam_files-exam_id',
            'import_exam_files',
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
        $this->dropTable('{{%import_exam_files}}');
    }
}
