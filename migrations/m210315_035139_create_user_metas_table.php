<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_metas}}`.
 */
class m210315_035139_create_user_metas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_metas}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'meta_key' => $this->string(),
            'meta_value' => $this->string(),
        ]);

        $this->createIndex(
            'idx-user_metas-user_id',
            'user_metas',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_metas-user_id',
            'user_metas',
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
        $this->dropTable('{{%user_metas}}');
    }
}
