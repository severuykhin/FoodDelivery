<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Page;
use yii\web\NotFoundHttpException;

class PagesController extends Controller
{
    public function actionPage($slug)
    {
        $page = Page::find()->where(['slug' => $slug])->one();
        
        $this->view->title = 'Кафе Шумовка - ' . $page->title;
        return $this->render('page', [
            'page' => $page
        ]);
    }

}