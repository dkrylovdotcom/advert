<?php

use yii\db\Migration;

use core\modules\control\rbac\Rbac as CoreRbac;
use modules\advert\rbac\Rbac;

class m180216_080343_advert_rbac_init extends Migration
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
    }

    public function down()
    {
        $this->delete('{{%auth_items}}', ['name' => Rbac::PERM_ADVERT_ZONE_VIEW]);
        $this->delete('{{%auth_items}}', ['name' => Rbac::PERM_ADVERT_ZONE_EDIT]);
        $this->delete('{{%auth_items}}', ['name' => Rbac::PERM_ADVERT_VIEW]);
        $this->delete('{{%auth_items}}', ['name' => Rbac::PERM_ADVERT_EDIT]);
    }
}
