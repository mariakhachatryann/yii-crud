<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders_transactions".
 *
 * @property int|null $user_id
 * @property int|null $book_id
 * @property int|null $amount
 * @property int $order_id
 *
 * @property User $user
 */
class OrderTransaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'order_id'], 'integer'],
            [['order_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'amount' => 'Amount',
            'order_id' => 'Order ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
