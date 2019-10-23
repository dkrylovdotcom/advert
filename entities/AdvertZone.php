<?php

namespace modules\advert\entities;

use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


class AdvertZone extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($name, $identity)
    {
        $advertZone = new static();
        $advertZone->identity = $identity;
        $advertZone->name = $name;
        $advertZone->status = self::STATUS_DRAFT;
        return $advertZone;
    }

    public function edit($name, $identity)
    {
        $this->identity = $identity;
        $this->name = $name;
    }

    public function activate()
    {
        if ($this->isActive()) {
            throw new \DomainException('This item is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft()
    {
        if ($this->isDraft()) {
            throw new \DomainException('This item is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function haveAdvert()
    {
        return ($this->advert) ? true : false;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }


    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
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
        ];
    }


    public static function tableName()
    {
        return '{{%advert_zone}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'identity' => 'Идентификатор',
            'name' => 'Название',
            'status' => 'Статус',
            'add_date' => 'Дата добавления'
        ];
    }


    public function getAdvert()
    {
        return $this->hasMany(Advert::class, ['zone_id' => 'id'])
            ->andOnCondition(['status' => AdvertItem::STATUS_ACTIVE])
            ->andOnCondition('`start_date`<=NOW()')
            ->andOnCondition('`end_date`>NOW()');
    }
}
