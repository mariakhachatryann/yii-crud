<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders_items}}`.
 */
class m240626_093201_create_order_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'order_id' => $this->integer(),
            'quantity' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_order_items_book_id',
            '{{%order_items}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_order_items_order_id',
            '{{%order_items}}',
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
        $this->dropForeignKey('fk_order_items_order_id', '{{%order_items}}');
        $this->dropForeignKey('fk_order_items_book_id', '{{%order_items}}');

        $this->dropTable('{{%order_items}}');
    }
}
