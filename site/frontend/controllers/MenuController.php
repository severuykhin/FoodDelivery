<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Category;
use yii\web\NotFoundHttpException;

class MenuController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCategory($slug)
    {
        $category = Category::findBySlug($slug);

        if (!$category) {
            echo 'sdfsdfsdf'; die;
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('category', [
            'category' => $category
        ]);
    }

}