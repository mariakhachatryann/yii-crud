<?php

namespace frontend\controllers;

use common\models\Book;
use Yii;
use common\models\Order;
use common\models\OrderTransaction;
use common\models\OrderItems;
use common\models\OrderAddresses;

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
        $orderAddress = new OrderAddresses();

        if ($orderAddress->load(Yii::$app->request->post()) && $orderAddress->validate()) {
            $cartItems = $user->cart;

            $order = new Order();
            $order->user_id = $user->id;
            $order->save();

            Yii::$app->session->set('orderId', $order->id);

            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItems();
                $orderItem->order_id = $order->id;
                $orderItem->book_id = $cartItem->book_id;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->save();

                $orderTransaction = new OrderTransaction();
                $orderTransaction->order_item_id = $orderItem->id;

                $book = Book::findOne(['_id' => $orderItem->book_id]);
                $orderTransaction->amount = $book->price * $orderItem->quantity;
                $orderTransaction->save();

                $cartItem->delete();

//                $authors = $orderItem->book->getAuthors()->all();
//                foreach ($authors as $author) {
//                    $author->updateBalance();
//                }
            }

            $orderAddress->order_id = $order->id;

            if (!$orderAddress->save()) {
                Yii::$app->session->setFlash('error', 'Failed to save order address.');
            } else {
                Yii::$app->session->setFlash('success', 'Order address saved successfully.');
            }

            return $this->redirect(['cart/index']);
        }

        return $this->render('details', [
            'model' => $orderAddress,
        ]);
    }

}
