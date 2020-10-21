<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_items}}`.
 */
class m201015_032853_create_post_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_items}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'child_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-post_items-parent_id',
            'post_items',
            'parent_id'
        );

        $this->addForeignKey(
            'fk-post_items-parent_id',
            'post_items',
            'parent_id',
            'posts',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-post_items-child_id',
            'post_items',
            'child_id'
        );

        $this->addForeignKey(
            'fk-post_items-child_id',
            'post_items',
            'child_id',
            'posts',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_items}}');
    }
}
