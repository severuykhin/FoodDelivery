<?php

namespace backend\controllers;

use Yii;

use yii\data\ActiveDataProvider;

use common\models\Review;
use common\models\Image;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\helpers\VarDumper;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ReviewsController extends Controller
{
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Review::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
	            'pageSize' => 50,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new Review();

        if (Yii::$app->request->isPost) {

            $file = UploadedFile::getInstance($model, 'image');

            if ($file) {
                $tempImg = Image::uploadFile($file, Review::UPLOAD_DIR);
                $model->pic = $tempImg;
            }

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Review::findOne($id);

        if (Yii::$app->request->isPost) {
            
            $file = UploadedFile::getInstance($model, 'image');

            if ($file) {
                $oldFile = !empty($model->pic) ? $model->pic : null;
                $tempImg = Image::uploadFile($file, Review::UPLOAD_DIR, $oldFile);
                $model->pic = $tempImg;
            }

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (Yii::$app->request->isPost) {
            $model = Review::findOne($id);
            $delPic = true;

            if (!empty($model->pic)) {
                $delPic = Image::deleteFile($model->pic, Review::UPLOAD_DIR);
            }

            if ($delPic && $model->delete()) {
                $this->redirect(['index']);
            }
        }
    }
}

