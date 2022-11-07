<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BooksSearch represents the model behind the search form of `common\models\Books`.
 */
class BooksSearch extends Books
{
    /**
     * {@inheritdoc}
     */
    public $authors;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'authors'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchById($id)
    {
        $query = Books::find()->where(['id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;

    }

    public function search($params)
    {
        $query = Books::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith(['authors']);

        // grid filtering conditions
        $query->andFilterWhere([
            'books.id' => $this->id,
            'books.name' => $this->name,
        ]);
        $query->andFilterWhere(['in', 'author_id', $this->authors]);
        return $dataProvider;
    }
}

?>