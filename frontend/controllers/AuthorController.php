<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\Order;
use Yii;

class AuthorController extends \common\helpers\BookCrudActions
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

        // Fetch all books associated with the author
        $books = $author->getBooks()->all();

        // Extract book IDs for filtering orders
        $bookIds = [];
        foreach ($books as $book) {
            $bookIds[] = $book->id;
        }

        // Retrieve orders where any book associated with the author has been ordered
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

                // Ensure the book is associated with the author
                if (in_array($book->id, $bookIds)) {
                    $numberOfAuthors = $book->getAuthors()->count();
                    $price = $book->price;

                    // Calculate share per author based on number of authors
                    if ($numberOfAuthors > 1) {
                        $sharePerAuthor = ($price * $item->quantity) / $numberOfAuthors;
                    } else {
                        $sharePerAuthor = $price * $item->quantity;
                    }

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
