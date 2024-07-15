<?php

namespace common\models;

use Yii;
use yii\elasticsearch\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $publication_year
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Book extends \yii\db\ActiveRecord
{
    public $authorsIds;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['publication_year', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'integer'],
            [['authorsIds'], 'each', 'rule' => ['integer']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'publication_year' => 'Publication Year',
            'price' => 'Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'imageFile' => 'Image',
        ];
    }

    public function getAuthorBook()
    {
        return $this->hasMany(AuthorBook::class, ['book_id' => 'id']);
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->via('authorBook');
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        ElasticBookSearch::indexBook($this);
    }
}
