<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\Dish;
use common\models\DishModification;
use common\models\Category;
use common\models\Image;
use common\models\CartItem;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use himiklab\sortablegrid\SortableGridAction;


class MenuController extends Controller
{

    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => Dish::className(),
            ],
        ];
    }

    public function actionIndex()
    {
        $categories = Category::getTitlesArray();
        $dataProvider = new ActiveDataProvider([
            'query' => Dish::find()->with(['category', 'modifications'])->orderBy(['sort' => SORT_ASC]),
            'pagination' => [
	            'pageSize' => 150,
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
        $model      = Dish::find()->where(['id' => $id])->with(['category', 'modifications'])->one();
        $categories = Category::getTitlesArray();
        $dishModification = new DishModification();

        // VarDumper::dump(Yii::$app->request->post(), 10, true); die;

        if (Yii::$app->request->post('DishModification')['id']) {
            $mod = DishModification::find()->where(['id' => Yii::$app->request->post('DishModification')['id']])->one();
            $mod->value = Yii::$app->request->post('DishModification')['value'];
            $mod->price = Yii::$app->request->post('DishModification')['price'];
            $mod->weight = Yii::$app->request->post('DishModification')['weight'];
            $mod->save();
            return $this->redirect([
                'update',
                'id' => $model->id,
            ]);
        }

        if (Yii::$app->request->post('delete-param')) {
            DishModification::deleteAll(['id' => Yii::$app->request->post('delete-param')]);
            CartItem::deleteAll(['modification_id' => Yii::$app->request->post('delete-param')]);
            return $this->redirect([
                'update',
                'id' => $model->id,
            ]);
        }


        if ($dishModification->load(Yii::$app->request->post())) 
        {
            if ($dishModification->save()) 
            {
                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                var_dump($dishModification->errors);
            }
        }


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) & $model->validate()) {
                if($model->save()) {
                    $this->redirect(['menu/view?id=' . $model->id]);
                }
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => DishModification::find()->where(['dish_id' => $id])
        ]);

        return $this->render('update', [
            'model'      => $model,
            'dishModification' => $dishModification,
            'dishModifications' => $dataProvider,
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