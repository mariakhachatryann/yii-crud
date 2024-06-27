<?php

use yii\db\Migration;

/**
 * Class m240624_142327_add_user_id_to_authors
 */
class m240624_142327_add_user_id_to_authors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%authors}}', 'user_id', $this->integer()->notNull());
        $this->addColumn('{{%authors}}', 'balance', $this->integer()->notNull());

        $this->addForeignKey(
            'fk-authors-user_id',
            '{{%authors}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-authors-user_id', '{{%authors}}');

        $this->dropColumn('{{%authors}}', 'user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240624_142327_add_user_id_to_authors cannot be reverted.\n";

        return false;
    }
    */
}
