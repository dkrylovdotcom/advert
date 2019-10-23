<?php

use yii\db\Migration;

use core\modules\control\rbac\Rbac as CoreRbac;
use modules\advert\rbac\Rbac;

class m180216_080343_advert_module_init extends Migration
{
    public function up()
    {
        $this->batchInsert('{{%auth_items}}', ['name', 'type', 'description', 'created_at', 'updated_at'], [
            [Rbac::PERM_ADVERT_ZONE_VIEW, 2, 'Просматривать рекламные зоны', time(), time()],
            [Rbac::PERM_ADVERT_ZONE_EDIT, 2, 'Редактировать и удалять рекламные зоны', time(), time()],
            [Rbac::PERM_ADVERT_VIEW, 2, 'Просматривать рекламные объявления', time(), time()],
            [Rbac::PERM_ADVERT_EDIT, 2, 'Редактировать и удалять рекламные объявления', time(), time()],
        ]);


        $this->batchInsert('{{%auth_item_children}}', ['parent', 'child'], [
            [CoreRbac::ROLE_ROOT, Rbac::PERM_ADVERT_ZONE_VIEW],
            [CoreRbac::ROLE_ROOT, Rbac::PERM_ADVERT_ZONE_EDIT],
            [CoreRbac::ROLE_ROOT, Rbac::PERM_ADVERT_VIEW],
            [CoreRbac::ROLE_ROOT, Rbac::PERM_ADVERT_EDIT],
        ]);


        // TODO::тут нужно узнавать ID модуля в системе. Иначе по другому нужно реализовывать.
        $this->batchInsert('{{%module_image}}', ['module_id', 'entity', 'name', 'width', 'height', 'default'], [
            [7, 'modules\advert\entities\AdvertItem', 'origin', 640, 640, 1],
            [7, 'modules\advert\entities\AdvertItem', 'thumb', 250, 250, 1],
        ]);
    }

    public function down()
    {
        $this->delete('{{%auth_items}}', ['name' => Rbac::PERM_ADVERT_ZONE_VIEW]);
        $this->delete('{{%auth_items}}', ['name' => Rbac::PERM_ADVERT_ZONE_EDIT]);
        $this->delete('{{%auth_items}}', ['name' => Rbac::PERM_ADVERT_VIEW]);
        $this->delete('{{%auth_items}}', ['name' => Rbac::PERM_ADVERT_EDIT]);
    }
}
