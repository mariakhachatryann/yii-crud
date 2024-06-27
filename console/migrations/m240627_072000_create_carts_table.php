<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%carts}}`.
 */
class m240627_072000_create_carts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%carts}}', [
            'user_id' => $this->integer(),
            'book_id' => $this->integer(),
            'quantity' => $this->integer(),
            'PRIMARY KEY(user_id, book_id)',
        ]);

        $this->addForeignKey(
            'fk_cart_user_id',
            '{{%carts}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_cart_book_id',
            '{{%carts}}',
            'book_id',
            '{{%books}}',
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
        $this->dropForeignKey('fk_cart_user_id', '{{%carts}}');
        $this->dropForeignKey('fk_cart_book_id', '{{%carts}}');
        $this->dropTable('{{%carts}}');
    }
}
