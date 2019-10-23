<?php

use yii\db\Migration;

/**
 * Handles the creation of table `advert_item`.
 */
class m171216_193646_create_advert_item_table extends Migration
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

        $this->createTable('{{%advert_item}}', [
            'id' => $this->primaryKey()->unique(),
            'advert_id' => $this->integer()->notNull(),
            'link' => $this->string(),
            'image' => $this->string()->notNull(),
            'status' => $this->smallInteger(1)->notNull(),
            'sort' => $this->integer(11)->notNull()->defaultValue(0),
            'edit_date' => $this->dateTime()->notNull(),
            'add_date' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-advert_item-advert_id}}', '{{%advert_item}}', 'advert_id');
        $this->addForeignKey('{{%fk-advert_item-advert_id}}', '{{%advert_item}}', 'advert_id', '{{%advert}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%advert_item}}');
    }
}
