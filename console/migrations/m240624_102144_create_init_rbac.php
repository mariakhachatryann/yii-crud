<?php

use yii\db\Migration;

/**
 * Class m240624_102144_create_init_rbac
 */
class m240624_102144_create_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $userRole = $auth->getRole(\common\models\User::USER);
        if (!$userRole) {
            $userRole = $auth->createRole(\common\models\User::USER);
            $auth->add($userRole);
        }

        $authorRole = $auth->getRole(\common\models\User::AUTHOR);
        if (!$authorRole) {
            $authorRole = $auth->createRole(\common\models\User::AUTHOR);
            $auth->add($authorRole);
        }
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        // Remove roles if needed (reverse of safeUp)
        $userRole = $auth->getRole(\common\models\User::USER);
        if ($userRole) {
            $auth->remove($userRole);
        }

        $authorRole = $auth->getRole(\common\models\User::AUTHOR);
        if ($authorRole) {
            $auth->remove($authorRole);
        }
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240624_102144_create_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
