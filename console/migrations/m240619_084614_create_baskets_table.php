<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%basket}}`.
 */
class m240619_084614_create_baskets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%baskets}}', [
            'user_id' => $this->integer(),
            'book_id' => $this->integer(),
            'count' => $this->integer(),
            'PRIMARY KEY(user_id, book_id)',
        ]);

        $this->addForeignKey(
            'fk_basket_user_id',
            '{{%baskets}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_basket_book_id',
            '{{%baskets}}',
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
        $this->dropForeignKey('fk_basket_user_id', '{{%basket}}');
        $this->dropForeignKey('fk_basket_book_id', '{{%basket}}');

        $this->dropTable('{{%basket}}');
    }
}
