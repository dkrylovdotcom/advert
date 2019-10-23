<?php

namespace modules\advert\forms\search;

use modules\advert\entities\Advert;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AdvertSearch extends Model
{
    public $id;
    public $zoneId;

    public function rules()
    {
        return [
            [['id', 'zoneId'], 'integer'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $query = Advert::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
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
            ->andFilterWhere(['zone_id' => $this->zoneId]);

        return $dataProvider;
    }
}
