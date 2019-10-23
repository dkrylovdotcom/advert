<?php

namespace modules\advert\forms\search;

use modules\advert\entities\AdvertZone;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ZoneSearch extends Model
{
    public $id;
    public $identity;
    public $name;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'identity'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $query = AdvertZone::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['like', 'identity', $this->identity])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
