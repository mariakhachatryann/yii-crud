<?php

namespace backend\controllers;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends \common\helpers\BookCrudActions
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors()
        );
    }

}
