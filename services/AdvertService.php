<?php

namespace modules\advert\services;

use modules\advert\forms\AdvertItemForm;
use modules\advert\repositories\AdvertRepository;
use modules\advert\entities\Advert;
use modules\advert\forms\AdvertForm;

class AdvertService
{
    private $adverts;

    public function __construct(AdvertRepository $adverts)
    {
        $this->adverts = $adverts;
    }

    public function create(AdvertForm $form)
    {
        $advert = Advert::create(
            $form->zoneId,
            $form->isRotate,
            $form->description,
            $form->startDate,
            $form->endDate
        );
        $this->adverts->save($advert);
        return $advert;
    }

    public function edit($id, AdvertForm $form)
    {
        $advert = $this->adverts->get($id);

        $advert->edit(
            $form->zoneId,
            $form->isRotate,
            $form->description,
            $form->startDate,
            $form->endDate
        );
        $this->adverts->save($advert);
    }


    public function remove($id)
    {
        $advert = $this->adverts->get($id);
        $this->adverts->remove($advert);
    }


    public function activate($id)
    {
        $advert = $this->adverts->get($id);
        $advert->activate();
        $this->adverts->save($advert);
    }

    public function draft($id)
    {
        $advert = $this->adverts->get($id);
        $advert->draft();
        $this->adverts->save($advert);
    }


    public function addItems($id, AdvertItemForm $form)
    {
        $link = null;
        $advert = $this->adverts->get($id);
        foreach ($form->files as $file) {
            $advert->addItem($file, $advert->id, $link);
        }
        $this->adverts->save($advert);
    }

    public function moveItemUp($id, $itemId)
    {
        $advert = $this->adverts->get($id);
        $advert->moveItemUp($itemId);
        $this->adverts->save($advert);
    }

    public function moveItemDown($id, $itemId)
    {
        $advert = $this->adverts->get($id);
        $advert->moveItemDown($itemId);
        $this->adverts->save($advert);
    }

    public function toggleItemStatus($id, $itemId)
    {
        $advert = $this->adverts->get($id);
        $advert->toggleItemStatus($itemId);
        $this->adverts->save($advert);
    }

    public function removeItem($id, $photoId)
    {
        $advert = $this->adverts->get($id);
        $advert->removeItem($photoId);
        $this->adverts->save($advert);
    }
}