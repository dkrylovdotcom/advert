<?php

namespace modules\advert\forms;

use modules\advert\entities\AdvertZone;
use yii\base\Model;

class AdvertZoneForm extends Model
{
    public $name;
    public $identity;

    public function __construct(AdvertZone $advertZone = null, $config = [])
    {
        if ($advertZone) {
            $this->name = $advertZone->name;
            $this->identity = $advertZone->identity;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'identity'], 'string', 'max' => 255],
            [['name', 'identity'], 'required']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'identity' => 'Идентификатор зоны',
            'edit_date' => 'Дата редактирования',
            'add_date' => 'Дата добавления',
        ];
    }
}