<?php

namespace modules\advert\repositories;

use core\exceptions\NotFoundException;
use modules\advert\entities\AdvertZone;

class AdvertZoneRepository
{
    public function get($id)
    {
        if(!$advertZone = AdvertZone::findOne($id)) {
            throw new NotFoundException('Advert zone is not found.');
        }
        return $advertZone;
    }

    public function save(AdvertZone $advertZone)
    {
        if (!$advertZone->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(AdvertZone $advertZone)
    {
        if (!$advertZone->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}