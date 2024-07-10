<?php

namespace frontend\controllers;

use common\models\Order;
use Yii;
use yii\helpers\ArrayHelper;

class AuthorController extends \common\helpers\BookCrudActions
{
    public $layout = 'main';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionBooks()
    {

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
        $bookIds = ArrayHelper::getColumn($books, 'id');

        $orders = Order::find()
            ->with('orderItems.book')
            ->joinWith('orderItems.book')
            ->andWhere(['in', 'order_items.book_id', $bookIds])
            ->distinct()
            ->all();

        $ordersData = [];

        foreach ($orders as $order) {
            $orderDetails = [
                'orderId' => $order->id,
                'orderItems' => [],
            ];

            foreach ($order->orderItems as $item) {
                $book = $item->book;

                if (in_array($book->id, $bookIds)) {
                    $numberOfAuthors = $book->getAuthors()->count();
                    $price = $book->price;

                    $sharePerAuthor = ($price * $item->quantity) / $numberOfAuthors;

                    $orderDetails['orderItems'][] = [
                        'bookId' => $book->id,
                        'title' => $book->title,
                        'description' => $book->description,
                        'price' => $price,
                        'quantity' => $item->quantity,
                        'authorShare' => $sharePerAuthor,
                        'imageFile' => $book->imageFile,
                    ];
                }
            }

            $ordersData[] = $orderDetails;
        }

        return $this->render('orders', [
            'ordersData' => $ordersData,
        ]);
    }
}
