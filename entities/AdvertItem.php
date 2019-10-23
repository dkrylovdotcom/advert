<?php

namespace modules\advert\entities;

use yii\db\Expression;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use yiidreamteam\upload\ImageUploadBehavior;
use core\modules\control\traits\ImageExtender;


class AdvertItem extends ActiveRecord
{
    use ImageExtender;

    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;


    public static function create(UploadedFile $image, $advertId, $link)
    {
        $advertItem = new static();
        $advertItem->advert_id = $advertId;
        $advertItem->link = $link;
        $advertItem->image = $image;
        $advertItem->status = self::STATUS_ACTIVE;
        return $advertItem;
    }

    public function edit($advertId, $link)
    {
        $this->advert_id = $advertId;
        $this->link = $link;
    }

    public function toggleStatus()
    {
        $this->status = ($this->status == self::STATUS_ACTIVE) ? self::STATUS_DRAFT : self::STATUS_ACTIVE;
        $this->save();
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function appendPhoto(UploadedFile $file)
    {
        $this->image = $file;
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

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }


    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isIdEqualTo($id)
    {
        return $this->id == $id;
    }


    public function behaviors()
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'image',
                'filePath' => '@staticRoot/origin/modules/advert/[[attribute_advert_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/modules/advert/[[attribute_advert_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/modules/advert/[[attribute_advert_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/modules/advert/[[attribute_advert_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => $this->getThumbs(),
            ],
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
        return '{{%advert_item}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'advert_id' => 'Объявление',
            'link' => 'Ссылка',
            'status' => 'Статус',
        ];
    }
}
