<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m201014_090631_alter_table_user
 */
class m201014_090631_alter_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'auth_key', $this->string()->defaultValue(NULL));
        $this->alterColumn('user', 'created_at', $this->timestamp()->defaultValue(NULL));
        $this->alterColumn('user', 'updated_at', $this->timestamp()->defaultValue(NULL));

        $user = new User;
        $user->username = "master";
        $user->email = "master@master.com";
        $user->password_hash = "semogasukses";
        $user->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201014_090631_alter_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201014_090631_alter_table_user cannot be reverted.\n";

        return false;
    }
    */
}
