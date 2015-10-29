<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'register_time', 'status'], 'integer'],
            [['nickname', 'username', 'password', 'email', 'website', 'role', 'register_ip', 'info'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'register_time' => $this->register_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'name', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'register_ip', $this->register_ip])
            ->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'ext', $this->ext]);

        return $dataProvider;
    }
}
