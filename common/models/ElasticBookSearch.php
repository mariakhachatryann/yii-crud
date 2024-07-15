<?php

namespace common\models;

use Yii;
use yii\elasticsearch\Query;
use yii\elasticsearch\ActiveRecord;

/**
 * This is the model class for table "books".
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $publication_year
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ElasticBookSearch extends ActiveRecord
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
                    'id' => ['type' => 'integer'],
                    'title' => ['type' => 'text'],
                    'description' => ['type' => 'text'],
                    'publication_year' => ['type' => 'integer'],
                    'price' => ['type' => 'integer'],
                    'imageFile' => ['type' => 'array'],
                    'authorsIds' => [
                        'type' => 'nested'
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
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
    public static function indexBook(Book $book)
    {
        try {
            $authorsIds = array_map('intval', (array) $book->authorsIds);

            $model = new static();
            $model->setAttributes([
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'publication_year' => $book->publication_year,
                'imageFile' => $book->imageFile,
                'price' => $book->price,
                'authorsIds' => $authorsIds
            ]);

            $model->save(false);
        } catch (\Exception $e) {
            Yii::error('Failed to index book ID ' . $book->id . ' into Elasticsearch: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes a Book model from Elasticsearch.
     * @param Book $book
     * @return bool
     */
    public static function deleteBook(Book $book)
    {
        try {
            Yii::$app->elasticsearch->createCommand()->delete(static::index(), static::type(), $book->id);
            return true;
        } catch (\Exception $e) {
            Yii::error('Failed to delete book ID ' . $book->id . ' from Elasticsearch: ' . $e->getMessage());
            return false;
        }
    }

    public static function getAllBooks()
    {
        $query = new Query();
        $query->from(static::indexName(), static::typeName());
        $response = $query->search(Yii::$app->elasticsearch);
        return $response;
    }

}
