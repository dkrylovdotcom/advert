<?php

namespace modules\advert\forms;

use modules\advert\entities\Advert;
use yii\base\Model;

class AdvertForm extends Model
{
    public $zoneId;
    public $isRotate;
    public $description;
    public $startDate;
    public $endDate;

    public function __construct(Advert $advert = null, $config = [])
    {
        if ($advert) {
            $this->zoneId = $advert->zone_id;
            $this->isRotate = $advert->is_rotate;
            $this->description = $advert->description;
            $this->startDate = $advert->start_date;
            $this->endDate = $advert->end_date;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['zoneId', 'isRotate'], 'integer'],
            ['zoneId', 'required'],
            ['description', 'string'],
            [['startDate', 'endDate'], 'default', 'value' => date("Y-m-d H:i:s")],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'zoneId' => 'Рекламная зона',
            'isRotate' => 'Ротация',
            'description' => 'Описание',
            'startDate' => 'Дата начала показа',
            'endDate' => 'Дата окончание показа',
        ];
    }
}