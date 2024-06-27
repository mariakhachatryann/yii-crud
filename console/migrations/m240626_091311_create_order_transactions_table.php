<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders_transactions}}`.
 */
class m240626_091311_create_order_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_transactions}}', [
            'order_id' => $this->integer(),
            'amount' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk_order_transactions_order_id',
            '{{%order_transactions}}',
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
        $this->dropForeignKey('fk_order_transactions_order_id', '{{%order_transactions}}');

        $this->dropTable('{{%order_transactions}}');
    }
}
