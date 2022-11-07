<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Authors;

/**
 * AuthorSearch represents the model behind the search form of `app\models\Author`.
 */
class AuthorsSearch extends Authors
{
    /**
     * {@inheritdoc}
     */
    public $books;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'books'], 'safe'],
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
        $query = Authors::find()->where(['id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function search($params)
    {
        $query = Authors::find();

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

        $query->joinWith(['books']);
        // grid filtering conditions
        $query->andFilterWhere([
            'authors.id' => $this->id,
            'authors.name' => $this->name,
        ]);
        $query->andFilterWhere(['in', 'book_id', $this->books]);

        return $dataProvider;
    }
}
