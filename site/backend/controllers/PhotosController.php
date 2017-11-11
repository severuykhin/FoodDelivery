<?php

namespace backend\controllers;

use Yii;

use yii\data\ActiveDataProvider;

use common\models\Photo;
use common\models\Image;

use yii\helpers\VarDumper;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class PhotosController extends Controller
{
    public function actionIndex()
    {
        $photos = Photo::find()->orderBy(['main' => SORT_DESC])->all();

        return $this->render('index', [
            'photos' => $photos
        ]);
    }

    public function actionCreate()
    {
        $model = new Photo();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->setDate();

            $file = UploadedFile::getInstance($model, 'image');
            $tempFile = Image::uploadFile($file, Photo::UPLOAD_DIR);

            if ($tempFile) {
                $model->src = $tempFile;

                if ($model->validate() && $model->save()) {
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
        $model = Photo::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->setDate();

            $file = UploadedFile::getInstance($model, 'image');

            if ($file) {
                $tempFile = Image::uploadFile($file, Photo::UPLOAD_DIR);
                if ($tempFile) {
                    $model->src = $tempFile;
                }
            }

            if ($model->validate() && $model->save()) {
                $this->redirect(['index']);
            }
        }

        $model->getDate();

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = Photo::findOne($id);

        if (!model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->deletePhoto();

        if ($model->delete()) {
            $this->redirect(['index']);
        }
    }
}