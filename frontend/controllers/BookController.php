<?php

namespace frontend\controllers;

use common\models\Book;
use common\models\ElasticBookSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

use common\models\User;
class BookController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSearch()
    {
        $title = Yii::$app->request->get('title');
        $results = ElasticBookSearch::find()->query(['match' => ['title' => $title]])->all();
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $results,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
