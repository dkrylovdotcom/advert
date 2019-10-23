<?php

namespace modules\advert\repositories;

use core\exceptions\NotFoundException;
use modules\advert\entities\Advert;

class AdvertRepository
{
    public function get($id)
    {
        if(!$advert = Advert::findOne($id)) {
            throw new NotFoundException('Advert is not found.');
        }
        return $advert;
    }

    public function save(Advert $advert)
    {
        if (!$advert->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Advert $advert)
    {
        if (!$advert->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}