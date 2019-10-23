<?php

namespace modules\advert\entities;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\UploadedFile;


class Advert extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    const ROTATE_OFF = 0;
    const ROTATE_ON = 1;

    public static function create($zoneId, $isRotate, $description, $startDate, $endDate)
    {
        $advert = new static();
        $advert->zone_id = $zoneId;
        $advert->is_rotate = $isRotate;
        $advert->description = $description;
        $advert->start_date = $startDate;
        $advert->end_date = $endDate;
        $advert->status = self::STATUS_ACTIVE;
        return $advert;
    }

    public function edit($zoneId, $isRotate, $description, $startDate, $endDate)
    {
        $this->zone_id = $zoneId;
        $this->is_rotate = $isRotate;
        $this->description = $description;
        $this->start_date = $startDate;
        $this->end_date = $endDate;
    }

    public function activate()
    {
        if ($this->isActive()) {
            throw new \DomainException('Advert is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft()
    {
        if ($this->isDraft()) {
            throw new \DomainException('Advert is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }


    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isRotated()
    {
        return $this->is_rotate;
    }

    public function getRandomItem()
    {
        if($this->items) {
            $items = [];
            foreach($this->items as $item) {
                if($item->isActive()) {
                    $items[] = $item;
                }
            }

            $itemsCount = count($items);

            $randomNum = 0;
            if($itemsCount>1) {
                $randomNum = rand(0, ($itemsCount-1));
            }


            return $items[$randomNum];
        }
        return false;
    }


    /* Photos */
    public function addItem(UploadedFile $file, $advertId, $link)
    {
        $items = $this->items;
        $items[] = AdvertItem::create($file, $advertId, $link);

        $this->updateItems($items);
    }

    public function toggleItemStatus($id)
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($id)) {
                $item->toggleStatus();
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }


    public function removeItem($id)
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($id)) {
                unset($items[$i]);
                $this->updateItems($items);
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function removeItems()
    {
        $this->updateItems([]);
    }

    public function moveItemUp($id)
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($id)) {
                if ($prev = isset($items[$i - 1]) ? $items[$i - 1] : null) {
                    $items[$i - 1] = $item;
                    $items[$i] = $prev;
                    $this->updateItems($items);
                }
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function moveItemDown($id)
    {
        $items = $this->items;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($id)) {
                if ($next = isset($items[$i + 1]) ? $items[$i + 1] : null) {
                    $items[$i] = $next;
                    $items[$i + 1] = $item;
                    $this->updateItems($items);
                }
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    private function updateItems(array $items)
    {
        foreach ($items as $i => $item) {
            $item->setSort($i);
        }
        $this->items = $items;
    }


    public function getItems()
    {
        return $this->hasMany(AdvertItem::class, ['advert_id' => 'id']);
    }




    public static function tableName()
    {
        return '{{%advert}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'zone_id' => 'Позиция объявления',
            'is_rotate' => 'Ротация',
            'description' => 'Описание',
            'edit_date' => 'Дата редактирования',
            'add_date' => 'Дата добавления',
            'status' => 'Статус',
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => 'edit_date',
                'createdAtAttribute' => 'add_date',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['items'],
            ],
        ];
    }
}
