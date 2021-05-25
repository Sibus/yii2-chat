<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class UserFinder extends Model
{
    public $id;
    public $username;
    public $email;
    public $status;
    public $created_from;
    public $created_to;

    public function rules(): array
    {
        return [
            ['id', 'integer'],
            ['username', 'string', 'max' => 255],
            ['email', 'string', 'max' => 255],
            ['status', 'integer'],
            [['created_from', 'created_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'email', $this->email]);

        $from = $this->created_from ? strtotime($this->created_from) : null;
        $query->andFilterWhere(['>=', 'created_at', $from]);

        $to = $this->created_to ? strtotime($this->created_to . ' 23:59:59') : null;
        $query->andFilterWhere(['<=', 'created_at', $to]);

        return $dataProvider;
    }
}
