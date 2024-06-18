<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author_book}}`.
 */
class m240617_142539_create_author_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author_book}}', [
            'author_id' => $this->integer(),
            'book_id' => $this->integer(),
            'PRIMARY KEY(author_id, book_id)',
        ]);

        $this->addForeignKey(
            'author_id',
            '{{%author_book}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'book_id',
            '{{%author_book}}',
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
        $this->dropForeignKey('author_id', '{{%author_book}}');
        $this->dropForeignKey('book_id', '{{%author_book}}');

        $this->dropTable('{{%author_book}}');
    }
}
