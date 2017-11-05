<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Dish;
use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class MenuController extends Controller
{
    public function actionIndex()
    {
        $categories = Category::getTitlesArray();
        $dataProvider = new ActiveDataProvider([
            'query' => Dish::find()->with(['category'])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
	            'pageSize' => 100,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categories'   => $categories
        ]);
    }

    public function actionCreate()
    {
        $model      = new Dish();
        $categories = Category::getTitlesArray();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) & $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['/menu']);
                }
            }
        }

        return $this->render('create', 
        [
            'model'      => $model,
            'categories' => $categories
        ]);
    }

    public function actionUpdate($id)
    {
        $model      = Dish::findOne($id);
        $categories = Category::getTitlesArray();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) & $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['/menu']);
                }
            }
        }

        return $this->render('update', [
            'model'      => $model,
            'categories' => $categories
        ]);
    }

    public function actionDelete($id)
    {
        $model = Dish::findOne($id);
        
        if ($model) {
            if ($model->delete()) {
                $this->redirect(['/menu']);
            }
        }
    }
}