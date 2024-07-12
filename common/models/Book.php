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
class Book extends \yii\elasticsearch\ActiveRecord
{
    public $authorsIds;
    /**
     * {@inheritdoc}
     */
    public static function indexName()
    {
        return 'books';
    }

    public static function typeName()
    {
        return '_doc';
    }

    public static function mapping()
    {
        return [
            static::type() => [
                'properties' => [
                    'id' => ['type' => 'text'],
                    'title' => ['type' => 'text'],
                    'description' => ['type' => 'text'],
                    'publication_year' => ['type' => 'integer'],
                    'authors' => [
                        'type' => 'nested',
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'name' => ['type' => 'keyword'],
                        ],
                    ],
                ],
            ],
        ];
    }

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

    public function attributes()
    {
        return [
            'id',
            'title',
            'description',
            'publication_year',
            'price',
            'created_at',
            'updated_at',
            'imageFile',
            'authorsIds',
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
}
