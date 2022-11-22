<?php

use yii\db\Migration;

/**
 * Class m221109_112527_users
 */
class m221109_112527_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(),
            'login' => $this->string(),
            'password' => $this->string(),
            'role' => $this->integer(),
            'author_id' => $this->integer(),
            'authkey' => $this->string(),
            'accessToken' => $this->string(),
        ]);

        $this->createIndex(
            'idx-users-author_id',
            '{{%users}}',
            'author_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-users-author_id',
            '{{%users}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221109_112527_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221109_112527_users cannot be reverted.\n";

        return false;
    }
    */
}
