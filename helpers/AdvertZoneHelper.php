<?php

namespace modules\advert\helpers;

use modules\advert\entities\AdvertZone;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class AdvertZoneHelper
{
    public static function statusList()
    {
        return [
            AdvertZone::STATUS_DRAFT => 'В черновиках',
            AdvertZone::STATUS_ACTIVE => 'Активен',
        ];
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case AdvertZone::STATUS_DRAFT:
                $class = 'b-label b-label_default';
                break;
            case AdvertZone::STATUS_ACTIVE:
                $class = 'b-label b-label_success';
                break;
            default:
                $class = 'b-label b-label_default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function zonesList()
    {
        return ArrayHelper::map(AdvertZone::find()->andWhere(['status' => AdvertZone::STATUS_ACTIVE])->all(), 'id', 'name');
    }
}