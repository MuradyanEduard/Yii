<?php

use yii\db\Migration;

/**
 * Class m221103_074739_books_authors
 */
class m221103_074739_books_authors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_authors}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'author_id' => $this->integer()
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-books-authors-book_id',
            '{{%books_authors}}',
            'book_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-books-authors-book_id',
            '{{%books_authors}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            'idx-books-authors-author_id',
            '{{%books_authors}}',
            'author_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-books-authors-author_id',
            '{{%books_authors}}',
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
        echo "m221103_074739_books_authors cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221103_074739_books_authors cannot be reverted.\n";

        return false;
    }
    */
}
