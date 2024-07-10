<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_addresses".
 *
 * @property string|null $city
 * @property string|null $state
 * @property string|null $address
 * @property string|null $phone
 */
class OrderAddresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'state', 'address', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city' => 'City',
            'state' => 'State',
            'address' => 'Address',
            'phone' => 'Phone',
        ];
    }
}
