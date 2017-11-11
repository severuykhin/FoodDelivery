<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\Dish;
use common\models\Category;
use common\models\Image;
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

    /**
     * 
     * Создание пункта меню
     * 
     * 
     * */ 
    public function actionCreate()
    {
        $model      = new Dish();
        $categories = Category::getTitlesArray();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) & $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['menu/view?id=' . $model->id]);
                }
            }
        }

        return $this->render('create', 
        [
            'model'      => $model,
            'categories' => $categories
        ]);
    }

    /**
     * 
     * Редактирование пункта меню
     * 
     * 
     * */ 
    public function actionUpdate($id)
    {
        $model      = Dish::findOne($id);
        $categories = Category::getTitlesArray();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) & $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['menu/view?id=' . $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model'      => $model,
            'categories' => $categories
        ]);
    }

    /**
     * 
     * Загрузка изображения для пункта меню
     * 
     * 
     * */ 

    public function actionImage($id)
    {
        $image = new Image();
        $model = Dish::findOne($id);

        if (Yii::$app->request->isPost) {

            $file = UploadedFile::getInstance($image, 'image');

            $result = $model->saveImage($image->upload($file, $model->id));

            if (true === $result) {
                $this->redirect(['menu/view?id=' . $model->id]);
            }
        }

        return $this->render('image', [
            'model' => $model,
            'image' => $image
        ]);
    }

    /**
     * 
     * Просмотр пункта меню
     * 
     * 
     * */ 

    public function actionView($id)
    {   
        $model = Dish::findOne($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * 
     * Удаление пункта меню
     * 
     * 
     * */ 
    public function actionDelete($id)
    {
        $model = Dish::findOne($id);
        
        if ($model) {

            $delPic = Image::deleteDish($model->pic, $model->id);

            if ($model->delete()) {
                $this->redirect(['/menu']);
            }
        }
    }
}