<?php

namespace modules\advert\helpers;

use modules\advert\entities\Advert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class AdvertHelper
{
    public static function rotateVariants()
    {
        return [
            Advert::ROTATE_OFF => 'Без ротации',
            Advert::ROTATE_ON => 'С ротацией'
        ];
    }

    public static function rotateValue($isRotate)
    {
        return ArrayHelper::getValue(self::rotateVariants(), $isRotate);
    }

    public static function statusList()
    {
        return [
            Advert::STATUS_DRAFT => 'В черновиках',
            Advert::STATUS_ACTIVE => 'Активен',
        ];
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case Advert::STATUS_DRAFT:
                $class = 'b-label b-label_default';
                break;
            case Advert::STATUS_ACTIVE:
                $class = 'b-label b-label_success';
                break;
            default:
                $class = 'b-label b-label_default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}