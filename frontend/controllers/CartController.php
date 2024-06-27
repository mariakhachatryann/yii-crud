<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use frontend\models\CartSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->andWhere(['user_id' => Yii::$app->user->id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
     * @param int $user_id User ID
     * @param int $book_id Book ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $id = Yii::$app->request->post('id');
        $quantity = Yii::$app->request->post('quantity');

        $user = Yii::$app->user->identity;

        $cartItem = $user->getCart()->where(['book_id' => $id])->one();

        if ($cartItem === null) {
            $model = new Cart();
            $model->user_id = $user->id;
            $model->book_id = $id;
            $model->quantity = $quantity;
        } else {
            $cartItem->quantity += $quantity;
            $model = $cartItem;
        }

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Item added to cart successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to add item to cart.');
            Yii::error('Failed to save Cart model: ' . json_encode($model->errors));
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $user_id User ID
     * @param int $book_id Book ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($book_id)
    {
        $this->findModel($book_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $book_id Book ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($book_id)
    {
        $user_id = Yii::$app->user->id;
        if (($model = Cart::findOne(['user_id' => $user_id, 'book_id' => $book_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
