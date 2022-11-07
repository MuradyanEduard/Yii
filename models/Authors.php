<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $name
 *
 * @property BooksAuthors[] $bookAuthors
 */
class Authors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $booksArr;

    public static function tableName()
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['booksArr'], 'required', 'message' => "Select Books"]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'books' => 'Books'
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooksAuthors()
    {
        return $this->hasMany(BooksAuthors::class, ['author_id' => 'id']);
    }

    public function getBooks()
    {
        return $this->hasMany(Books::class, ['id' => 'book_id'])
            ->via('booksAuthors');
    }
}
