<?php

namespace frontend\controllers;

use Yii;
use common\models\Order;
use common\models\OrderTransaction;
use common\models\OrderItems;

class OrderController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        $orders = $user->orders;

        return $this->render('index', [
            'orders' => $orders,
        ]);
    }

    public function actionCheckout()
    {
        $user = Yii::$app->user->identity;

        $cartItems = $user->cart;

        $order = new Order();
        $order->user_id = $user->id;

        if (!$order->save()) {
            throw new \Exception('Failed to save order.');
        }

        $totalAmount = 0;

        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItems();
            $orderItem->order_id = $order->id;
            $orderItem->book_id = $cartItem->book_id;
            $orderItem->quantity = $cartItem->quantity;

            if (!$orderItem->save()) {
                throw new \Exception('Failed to save order item for book ID: ' . $cartItem->book_id);
            }

            $orderTransaction = new OrderTransaction();
            $orderTransaction->order_item_id = $orderItem->id;
            $orderTransaction->amount = $orderItem->book->price * $orderItem->quantity;
            $orderTransaction->save();

            $totalAmount += $orderItem->book->price * $orderItem->quantity;
            $cartItem->delete();

            $authors = $orderItem->book->getAuthors()->all();
            $numberOfAuthors = count($authors);
            $price = $orderItem->book->price;

            $sharePerAuthor = ($price * $orderItem->quantity) / $numberOfAuthors;

            foreach ($authors as $author) {
                $author->balance += $sharePerAuthor;
                $author->save();
            }

        }

        $order->save();

        Yii::$app->session->setFlash('success', 'Checkout successful! Order created.');

        return $this->redirect(['cart/index']);
    }
}
