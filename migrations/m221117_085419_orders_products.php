<?php

use yii\db\Migration;

/**
 * Class m221117_085419_orders_products
 */
class m221117_085419_orders_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders_products}}', [
            'id' => $this->primaryKey(),
            'order_id'=> $this->integer(),
            'book_id' => $this->integer(),
            'count'=> $this->integer(),
            'price'=> $this->decimal(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-orders_products-book_id',
            '{{%orders_products}}',
            'book_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-orders_products-book_id',
            '{{%orders_products}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            'idx-orders_products-order_id',
            '{{%orders_products}}',
            'order_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-orders_products-order_id',
            '{{%orders_products}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221117_085419_orders_products cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221117_085419_orders_products cannot be reverted.\n";

        return false;
    }
    */
}
