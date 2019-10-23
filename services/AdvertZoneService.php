<?php

namespace modules\advert\services;

use modules\advert\entities\AdvertZone;
use modules\advert\forms\AdvertZoneForm;
use modules\advert\repositories\AdvertZoneRepository;

class AdvertZoneService
{
    private $zones;

    public function __construct(AdvertZoneRepository $zones)
    {
        $this->zones = $zones;
    }

    public function create(AdvertZoneForm $form)
    {
        $advertZone = AdvertZone::create(
            $form->name,
            $form->identity
        );
        $this->zones->save($advertZone);
        return $advertZone;
    }

    public function edit($id, AdvertZoneForm $form)
    {
        $advertZone = $this->zones->get($id);

        $advertZone->edit(
            $form->name,
            $form->identity
        );
        $this->zones->save($advertZone);
    }
    public function remove($id)
    {
        $advertZone = $this->zones->get($id);
        $this->zones->remove($advertZone);
    }


    public function activate($id)
    {
        $advertZone = $this->zones->get($id);
        $advertZone->activate();
        $this->zones->save($advertZone);
    }

    public function draft($id)
    {
        $advertZone = $this->zones->get($id);
        $advertZone->draft();
        $this->zones->save($advertZone);
    }
}