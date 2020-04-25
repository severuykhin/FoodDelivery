<?php

namespace frontend\controllers;

use Yii;
use common\models\Category;
use common\models\Dish;
use common\models\Review;
use common\models\Photo;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\helpers\VarDumper;

/**
 * Отображение страниц сайта
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends Controller
{

    /**
     * Подключенные внешние экшены
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Подключенные поведения
     * @return array
     */
    public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'index' => ['get']
				],
			],
		];
	}

    /**
     * Главная страница
     * @return string
     */
    public function actionIndex()
	{
        // $actionDishes = Dish::find()
        //     ->where(['action' => Dish::STATUS_ACTIVE])
        //     ->all();

        $reviews    = Review::getBest();
        $bestDishes = Dish::getBest();
        $banners    = Photo::find()
                        ->where(['banner' => Photo::STATUS_ACTIVE])
                        ->orderBy(['created_at' => SORT_ASC])
                        ->asArray()
                        ->all();

        $aboutPhotos = Photo::find()
                        ->where(['main' => Photo::ON_MAIN])
                        ->limit(10)
                        ->asArray()
                        ->all();

        return $this->render('index', [
            'banners'      => $banners,
            'reviews'      => $reviews,
            'aboutPhotos'  => $aboutPhotos,
            'bestDishes'   => $bestDishes
        ]);
    }
    
    public function actionReviews()
    {
        $reviews = Review::find()->all();

        return $this->render('reviews', [
            'reviews' => $reviews
        ]);
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionAbout()
    {
        $about = Photo::find()->where(['about__block' => Photo::STATUS_ACTIVE])->all();
        $feed = Photo::find()->where(['feed' => Photo::STATUS_ACTIVE])->all();
        return $this->render('about', [
            'about' => $about,
            'feed'  => $feed
        ]);
    }

    public function actionSpasibo()
    {
        $orderNumber = Yii::$app->session->getFlash('orderSuccess');

        if (!$orderNumber) 
        {
            $this->redirect(['site/index']);
            Yii::$app->end();
        }

        return $this->render('spasibo', [
            'orderNumber' => $orderNumber
        ]);
    }

    public function actionSitemap()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=UTF-8');

        $this->layout = false;

        $categories = Category::find()->all();

        return $this->render('sitemap', [
            'categories' => $categories
        ]);
    }

    public function actionPartners() 
    {
        return $this->render('partners');
    }

}
