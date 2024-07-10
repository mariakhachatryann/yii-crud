<?php

use yii\db\Migration;

/**
 * Class m240627_115458_create_order_addresses
 */
class m240627_115458_create_order_addresses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_addresses}}', [
            'city' => $this->string(),
            'state' => $this->string(),
            'address' => $this->string(),
            'phone' => $this->string(),
            'order_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_order_addresses_order_id',
            '{{%order_addresses}}',
            'order_id',
            '{{%order}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240627_115458_create_order_addresses cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240627_115458_create_order_addresses cannot be reverted.\n";

        return false;
    }
    */
}
