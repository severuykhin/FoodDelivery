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
        return $this->render('index');
    }

    public function actionCategory($slug)
    {
        $category = Category::findBySlug($slug);

        if (!$category) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dishes = Dish::find()
            ->where(['category_id' => $category->id])
            ->andWhere(['active' => Dish::STATUS_ACTIVE])
            ->all();

        return $this->render('category', [
            'category' => $category,
            'dishes'   => $dishes
        ]);
    }

}