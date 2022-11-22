<?php

use yii\db\Migration;

/**
 * Class m221117_085242_orders
 */
class m221117_085242_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'total_sum'=> $this->decimal(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-orders-user_id',
            '{{%orders}}',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-orders-user_id',
            '{{%orders}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221117_085242_orders cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221117_085242_orders cannot be reverted.\n";

        return false;
    }
    */
}
