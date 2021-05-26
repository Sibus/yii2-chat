<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Message;

class MessageSearch extends Model
{
    public $id;
    public $author;
    public $content;
    public $created_from;
    public $created_to;
    public $hidden_from;
    public $hidden_to;

    public function rules()
    {
        return [
            ['id', 'integer'],
            ['author', 'string'],
            ['content', 'string'],
            [['created_from', 'created_to'], 'date', 'format' => 'php:Y-m-d'],
            [['hidden_from', 'hidden_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Message::find()->alias('m')->hidden();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['author u']);
        $query->andFilterWhere(['like', 'u.username', $this->author]);
        $query->andFilterWhere(['m.id' => $this->id]);
        $query->andFilterWhere(['like', 'm.content', $this->content]);

        $from = $this->created_from ? strtotime($this->created_from) : null;
        $query->andFilterWhere(['>=', 'm.created_at', $from]);

        $to = $this->created_to ? strtotime($this->created_to . ' 23:59:59') : null;
        $query->andFilterWhere(['<=', 'm.created_at', $to]);

        $from = $this->hidden_from ? strtotime($this->hidden_from) : null;
        $query->andFilterWhere(['>=', 'm.hidden_at', $from]);

        $to = $this->hidden_to ? strtotime($this->hidden_to . ' 23:59:59') : null;
        $query->andFilterWhere(['<=', 'm.hidden_at', $to]);

        return $dataProvider;
    }
}
