<?php

use yii\db\Migration;

/**
 * Handles the creation of table `advert`.
 */
class m171216_193641_create_advert_table extends Migration
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

        $this->createTable('{{%advert}}', [
            'id' => $this->primaryKey()->unique(),
            'zone_id' => $this->integer()->unique(),
            'is_rotate' => $this->smallInteger(1)->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger(1)->notNull(),
            'start_date' => $this->dateTime()->notNull(),
            'end_date' => $this->dateTime()->notNull(),
            'edit_date' => $this->dateTime()->notNull(),
            'add_date' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-advert-zone_id}}', '{{%advert}}', 'zone_id');
        $this->addForeignKey('{{%fk-advert-zone_id}}', '{{%advert}}', 'zone_id', '{{%advert_zone}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%advert}}');
    }
}
