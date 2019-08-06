<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\CartBonus;
use common\models\Category;
use common\models\Dish;
use common\models\CartOrder;
use frontend\components\Cart;
use yii\web\NotFoundHttpException;
use yii\base\Exception;
use yii\helpers\VarDumper;


class CartController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $order = new CartOrder();
        $cart = Cart::getInstance();

        if ($order->load(Yii::$app->request->post())) 
        {
            $order->cart_id = $cart->id;
            $order->save();
            $orderData = Cart::actualize();
            $order->send($orderData);
            $order->process($cart);
            Yii::$app->session->setFlash('orderSuccess', $order->id);
            $this->redirect(['site/spasibo']);
            Yii::$app->end();
        }

        $souses = Dish::find()->where(['category_id' => 20])->all();

        return $this->render('index', [
            'order' => $order,
            'souses' => $souses
        ]);
    }

    public function actionAdd()
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->controller->enableCsrfValidation = false;

        if (!Yii::$app->request->isPost) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        $cart = Cart::getInstance();

        $item = Yii::$app->request->post('item');
        $newItem = $cart->add($item);
        
        return [
            'result' => 'ok',
            'data'   => $newItem
        ];
    }

    public function actionRemove()
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->controller->enableCsrfValidation = false;

        if (!Yii::$app->request->isPost) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        $cart = Cart::getInstance();

        $item = Yii::$app->request->post('item');
        $newItem = $cart->remove($item);
        
        return [
            'result' => 'ok',
            'data'   => $newItem
        ];
    }

    public function actionDelete() 
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->controller->enableCsrfValidation = false;

        if (!Yii::$app->request->isPost) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        $cart = Cart::getInstance();

        $item = Yii::$app->request->post('item');
        if ($cart->deleteItem($item)) {
            return [
                'result' => 'ok',
            ];
        } else {
            throw new Exception('Error while deleting item');
        }
    }

}