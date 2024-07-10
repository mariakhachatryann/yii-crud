<?php

use yii\db\Migration;

/**
 * Class m240627_101322_add_status_to_orders
 */
class m240627_101322_add_status_to_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'status', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240627_101322_add_status_to_orders cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240627_101322_add_status_to_orders cannot be reverted.\n";

        return false;
    }
    */
}
