<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%participants}}`.
 */
class m201014_091746_create_participants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%participants}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'id_number' => $this->integer(),
            'name' => $this->string(),
            'address' => $this->text(),
            'phone' => $this->string(),
            'birthdate' => $this->date(),
            'age' => $this->string(),
            'school' => $this->string(),
            'study' => $this->string(),
            'work_time' => $this->string(),
        ]);

        $this->createIndex(
            'idx-participants-user_id',
            'participants',
            'user_id'
        );

        $this->addForeignKey(
            'fk-participants-user_id',
            'participants',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%participants}}');
    }
}
