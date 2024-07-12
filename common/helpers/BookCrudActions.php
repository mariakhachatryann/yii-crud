<?php

namespace common\helpers;

use app\models\BookSearch;
use common\models\Author;
use common\models\Book;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;

class BookCrudActions extends \yii\web\Controller
{
    public function actionIndex()
    {

        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->validate()) {
                if ($model->imageFile) {
                    $imageName = 'book_' . time() . '.' . $model->imageFile->extension;
                    $uploadPath = Yii::getAlias('@frontend/web/uploads/images/') . $imageName;

                    if ($model->imageFile->saveAs($uploadPath)) {
                        $model->imageFile = '/uploads/images/' . $imageName;
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to upload image.');
                        return $this->refresh();
                    }
                }

                if ($model->save()) {
                    $authorIds = $model->authorsIds;
                    if (!empty($authorIds)) {
                        $authors = Author::findAll($authorIds);
                        foreach ($authors as $author) {
                            $model->link('authors', $author);
                        }
                    }

                    Yii::$app->session->setFlash('success', 'Book created successfully.');
                    return $this->redirect(['view', 'id' => $model->_id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save book.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->validate()) {
                if ($model->imageFile) {
                    $imageName = 'book_' . time() . '.' . $model->imageFile->extension;
                    $uploadPath = Yii::getAlias('@frontend/web/uploads/images/') . $imageName;

                    if ($model->imageFile->saveAs($uploadPath)) {
                        $model->imageFile = '/uploads/images/' . $imageName;
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to upload image.');
                        return $this->refresh();
                    }
                }

                if ($model->save()) {
                    $model->unlinkAll('authors', true);

                    $authorIds = $model->authorsIds;
                    if (!empty($authorIds)) {
                        $authors = Author::findAll($authorIds);
                        foreach ($authors as $author) {
                            $model->link('authors', $author);
                        }
                    }

                    Yii::$app->session->setFlash('success', 'Book updated successfully.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to update book.');
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne(['_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}