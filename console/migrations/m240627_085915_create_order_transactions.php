<?php

use yii\db\Migration;

/**
 * Class m240627_085915_create_order_transactions
 */
class m240627_085915_create_order_transactions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_transactions}}', [
            'order_item_id' => $this->integer(),
            'amount' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk_order_transactions_order_item_id',
            '{{%order_transactions}}',
            'order_item_id',
            '{{%order_items}}',
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
        $this->dropForeignKey('fk_order_transactions_order_item_id', '{{%order_transactions}}');

        $this->dropTable('{{%order_transactions}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240627_085915_create_order_transactions cannot be reverted.\n";

        return false;
    }
    */
}
