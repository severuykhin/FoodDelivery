<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Cart;
use common\models\CartOrder;
use backend\models\ApiHelper;


/**
 * CartController implements the CRUD actions for Cart model.
 */
class ApiController extends Controller
{
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
                         'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function actionOrders()
    {
        $data = Yii::$app->request->get();
        $ordersInfo = ApiHelper::getOrdersSummary($data);

        $responseData;

        try {

            $responseData = [
                'result' => 'ok',
                'payload' => [
                    'avg' => $ordersInfo['avg'],
                    'count' => $ordersInfo['ordersCount'],
                    'biggest' => $ordersInfo['biggest'],
                    'perDay' => $ordersInfo['perDay'],
                    'totalSumm' => $ordersInfo['totalSumm'],
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

    public function beforeAction($action)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
}
