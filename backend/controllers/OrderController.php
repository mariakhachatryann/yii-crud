<?php

namespace backend\controllers;

use yii\web\Controller;
use common\models\Order;
use Yii;

class OrderController extends Controller
{
    public function actionIndex() {
        $orders = Order::find()->all();

        return $this->render('index', compact('orders'));
    }

    public function actionStatus()
    {
        $id = Yii::$app->request->post('id');
        $selectedStatus = Yii::$app->request->post('selectedStatus');

        $order = Order::findOne($id);
        $order->status = $selectedStatus;
        $order->save();
    }
}