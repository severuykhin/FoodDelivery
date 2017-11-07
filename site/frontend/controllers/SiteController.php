<?php

namespace frontend\controllers;

use Yii;
use common\models\Category;
use common\models\Dish;
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
        $actionDishes = Dish::find()->where(['action' => Dish::STATUS_ACTIVE])->all();

        return $this->render('index', [
            'actionDishes' => $actionDishes
        ]);
	}

}
