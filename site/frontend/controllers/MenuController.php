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

    public function actionCategory($slug = 'all')
    {
        if ($slug === 'all') {
            $categories = Category::find()->where(['<>', 'id', 20])->with(['dishes'])->all();
        } else {
            $categories = Category::find()->where(['slug' => $slug])->andWhere(['<>', 'id', 20])->with(['dishes'])->all();
        }

        if (!$categories)
        {
            throw  new NotFoundHttpException('Страница не найдена');
        }
            

        return $this->render('index', [
            'categories' => $categories,
            'slug' => $slug
        ]);
    }
}