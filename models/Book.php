<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string|null $author_id
 * @property string|null $img
 * @property string|null $date
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $authorsArr;

    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'],'safe'],
            [['name','price','count'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['authorsArr'], 'required', 'message' => "Select Authors"],
            [['price'],'number', 'numberPattern' => '/(^\d*\.?\d*[0-9]+\d*$)|(^[0-9]+\d*\.\d*$)/','message' => 'Number should be decimal!'],
            [['count'],'number', 'numberPattern' => '/(^\d*?\d*[0-9]+\d*$)/','message' => 'Number should be positive and natural!'],
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
            'authors' => 'Authors',
            'price' => 'Price',
            'count' => 'Count'
        ];
    }

    /**
     * {@inheritdoc}
     * @return \yii\db\ActiveQuery the active query used by this AR class.
     */


    public function getBooksAuthors()
    {
        return $this->hasMany(BookAuthors::class, ['book_id' => 'id']);
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->via('booksAuthors');
    }

    public function getProducts()
    {
        return $this->hasMany(OrderProduct::class, ['book_id' => 'id']);
    }
}

?>