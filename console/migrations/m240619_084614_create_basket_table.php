<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%basket}}`.
 */
class m240619_084614_create_basket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%basket}}', [
            'user_id' => $this->integer(),
            'book_id' => $this->integer(),
            'PRIMARY KEY(user_id, book_id)',
        ]);

        $this->addForeignKey(
            'fk_basket_user_id',
            '{{%basket}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_basket_book_id',
            '{{%basket}}',
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
