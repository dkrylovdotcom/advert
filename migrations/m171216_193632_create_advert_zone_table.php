<?php

use yii\db\Migration;

/**
 * Handles the creation of table `advert_zone`.
 */
class m171216_193632_create_advert_zone_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%advert_zone}}', [
            'id' => $this->primaryKey()->unique(),
            'name' => $this->string(255)->notNull(),
            'identity' => $this->string(255)->unique(),
            'status' => $this->smallInteger(1)->notNull(),
            'edit_date' => $this->dateTime()->notNull(),
            'add_date' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-advert_zone-identity}}', '{{%advert_zone}}', 'identity');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%advert_zone}}');
    }
}
