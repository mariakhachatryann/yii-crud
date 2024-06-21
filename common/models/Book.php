<?php

namespace common\models;

use Yii;

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
            [['title'], 'string', 'max' => 255],
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
}
