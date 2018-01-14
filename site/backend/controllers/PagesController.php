<?php

namespace backend\controllers;

use Yii;
use common\models\Widget;
use common\models\Page;

use yii\data\ActiveDataProvider;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\helpers\VarDumper;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;


    /**
     * Контроллер кастомный страниц
     * @package backend\controllers
     */
class PagesController extends Controller
{

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
                    'index'  => ['get'],
                    'create'    => ['get','post'],
                    'update'   => ['get', 'post'],
                    'delete' => ['get', 'post']
                ],
            ],
        ];
    }

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
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url'  => '/statics/uploads/pages',
                'path' => '@statics/uploads/pages' 
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Page::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
	            'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id)
    {
        $model = Page::findOne($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $model = new Page();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['/pages/view?id=' . $model->id]);
                }
            }
        }
        
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Page::findOne($id);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['/pages/view?id=' . $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = Page::findOne($id);

        if ($model) {
            if ($model->delete()) {
                $this->redirect(['/pages']);
            }
        }
    }

}