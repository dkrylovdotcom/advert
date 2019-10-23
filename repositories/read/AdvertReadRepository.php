<?php

namespace modules\advert\repositories\read;


use modules\advert\entities\Advert;
use modules\advert\entities\AdvertZone;

class AdvertReadRepository
{
    public function getAll()
    {
        return Advert::find()->all();
    }

    public function findByZone($identity)
    {
        $advertZone = AdvertZone::find()
            ->andWhere(['identity' => $identity])
            ->with('advert')
            ->limit(1)
            ->one();

        return $advertZone;
    }

    public function find($id)
    {
        return Advert::findOne($id);
    }
}