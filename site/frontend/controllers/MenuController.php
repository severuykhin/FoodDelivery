<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Category;
use common\models\Dish;
use yii\web\NotFoundHttpException;

class MenuController extends Controller
{

    public function actionIndex()
    {
        $categories = Category::find()
            ->with(['dishes'])
            ->orderBy(['sort' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'categories' => $categories
        ]);
    }

    public function actionCategory($slug)
    {
        if ($slug === 'all') {
            $categories = Category::find()->with(['dishes'])->all();
        } else {
            $categories = Category::find()->where(['slug' => $slug])->with(['dishes'])->all();
        } 
            

        return $this->render('index', [
            'categories' => $categories
        ]);
    }
}