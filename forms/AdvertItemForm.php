<?php

namespace modules\advert\forms;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * @property array $variants
 */
class AdvertItemForm extends Model
{
    public $files;

    public function rules()
    {
        return [
            ['files', 'each', 'rule' => ['image']]
        ];
    }

    public function beforeValidate()
    {
        if(parent::beforeValidate()) {
            $this->files = UploadedFile::getInstances($this, 'files');

            return true;
        }
        return false;
    }
}