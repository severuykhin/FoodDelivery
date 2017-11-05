<?php

namespace backend\controllers;

use Yii;
use common\models\Widget;
use common\models\Category;

use yii\data\ActiveDataProvider;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\helpers\VarDumper;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

use himiklab\sortablegrid\SortableGridAction;


    /**
     * Контроллер категорий
     * @package backend\controllers
     */
class CategoryController extends Controller
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
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => Category::className(),
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Yii::$app->urlManager->hostInfo . '/statics/images/categories',
				'path' => '@statics/images/categories' 
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find()->orderBy(['sort' => SORT_DESC]),
            'pagination' => [
	            'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['/category']);
                }
            }
        }
        
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Category::findOne($id);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['/category']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = Category::findOne($id);

        if ($model) {
            if ($model->delete()) {
                $this->redirect(['/category']);
            }
        }
    }

}