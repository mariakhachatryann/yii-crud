<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $biography
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['biography'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'biography' => 'Biography',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

        public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBook::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->viaTable('author_book', ['author_id' => 'id']);
    }

    public function getBookIds()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('author_book', ['author_id' => 'id'])
            ->select('id')
            ->column();
    }


    public function getOrders()
    {
        return Order::find()
            ->joinWith('orderItems.book')
            ->andWhere(['in', 'order_items.book_id', $this->getBookIds()])
            ->distinct();
    }
}
