<?php

namespace frontend\controllers;

use common\models\Author;
use common\models\Basket;
use Yii;

class AuthorController extends \backend\controllers\BookController
{
    public $layout = 'main';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionBooks() {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;
        $author = $user->author;

        if (!$author) {
            Yii::$app->session->setFlash('error', 'You are not associated with any author.');
            return $this->redirect(['site/index']);
        }

        return $this->render('books', [
            'books' => $author->books,
        ]);
    }

    public function actionOrders()
    {
        $user = Yii::$app->user->identity;
        $author = $user->author;
        $books = $author->getBooks()->all();

        $bookIds = [];
        foreach ($books as $book) {
            $bookIds[] = $book->id;
        }

        $basketItems = Basket::find()->where(['book_id' => $bookIds])->all();

        $booksInBasket = [];

        foreach ($basketItems as $item) {
            $book = $item->book;
            if ($book) {
                $authors = $book->getAuthors()->all();
                $numberOfAuthors = count($authors);
                $price = $book->price;

                if ($numberOfAuthors > 1) {
                    $sharePerAuthor = $price / $numberOfAuthors;
                } else {
                    $sharePerAuthor = $price;
                }

                $booksInBasket[] = [
                    'id' => $book->id,
                    'title' => $book->title,
                    'description' => $book->description,
                    'price' => $book->price,
                    'authorShare' => $sharePerAuthor,
                    'publicationYear' => $book->publication_year,
                    'imageFile' => $book->imageFile,
                    'count' => Basket::findOne(['book_id' => $book->id])->count
                ];
            }
        }

        return $this->render('orders', [
            'booksInBasket' => $booksInBasket,
        ]);
    }

}
