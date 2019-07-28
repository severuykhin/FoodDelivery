<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Cart;
use common\models\CartOrder;
use common\models\Report;
use backend\models\ApiHelper;


/**
 * CartController implements the CRUD actions for Cart model.
 */
class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['orders', 'customers', 'products'],
                'rules' => [
                    [
                        'actions' => ['orders', 'customers', 'products'],
                        'allow' => true,
                        //  'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function actionOrders()
    {
        $data = Yii::$app->request->get();
        $ordersInfo = ApiHelper::getOrdersSummary($data);

        $responseData = [];

        try {

            $responseData = [
                'result' => 'ok',
                'payload' => [
                    'avg' => $ordersInfo['avg'],
                    'count' => $ordersInfo['ordersCount'],
                    'biggest' => $ordersInfo['biggest'],
                    'perDay' => $ordersInfo['perDay'],
                    'totalSumm' => $ordersInfo['totalSumm'],
                    'reports' => $ordersInfo['reports']
                ],
                'error' => []
            ];

        } catch(\Throwable $e) {

            $responseData = [
                'result' => 'error',
                'error' => $e->getMessage()
            ];

        } finally {
            return $responseData;
        }
    }

    public function actionCustomers()
    {

        $customersSummary = CartOrder::getCustomerSummary();

        return $customersSummary;
    }

    public function actionProducts()
    {
        return [
            'result' => 'ok',
            'data' => CartOrder::getDishSummary()
        ];
    }

    public function actionReports()
    {
        if (Yii::$app->request->isGet) {

            $data = [];
            $result = '';

            try {
                $data = Report::find()->orderBy(['created_at' => SORT_DESC])->all();
                $result = 'ok';
            } catch (\Exception $e) {
                $data = $e->getMessage();
                $result = 'error';
            }

            return [
                'result' => $result,
                'data' => $data
            ];
        }

        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();

            if (isset($data['type']) && $data['type'] == 'delete') {
                $id = $data['id'];
                $model = Report::findOne($id);
                $model->delete();
                return ['result' => 'ok', 'id' => $id];
            } else {
                $model = new Report([
                    'title' => $data['title'],
                    'text' => $data['text'],
                    'created_at' => Yii::$app->formatter->asTimestamp($data['date'])
                ]);
    
                if ($model->save()) {
                    return ['result' => 'ok', 'data' => $model];
                } else {
                    return ['result' => 'error', 'data' => $model->errors];
                }
            }
        }

    }

    public function beforeAction($action)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
}
