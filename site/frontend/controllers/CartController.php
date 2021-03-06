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
use common\components\GoogleECommerce;
use common\events\EventDispatcher;
use common\events\OrderCreateEvent;

class CartController extends Controller
{

    public $enableCsrfValidation = false;

    private $eventDispatcher;

    public function __construct($id, $module, EventDispatcher $eventDispatcher, $config = [])
    {
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $order = new CartOrder();
        $cart = Cart::getInstance();

        if ($order->load(Yii::$app->request->post())) 
        {
            // Process and save cart order
            $order->cart_id = $cart->id;
            $order->save();
            $order->process($cart);
            
            try {

                $this->eventDispatcher->dispatch(new OrderCreateEvent($order));

                //Safely sending data to google analytics e-commerce
                $ga = new GoogleECommerce($order);
                $ga->sendOrder();
            } catch (\Exception $e) {
                $messageLog = [
                    'status' => 'GA transaction error',
                    'error' => $e->getMessage()
                ];

                Yii::info($messageLog, 'ga_transaction_error');
            }

            // Redirect user
            Yii::$app->session->setFlash('orderSuccess', $order->id);
            $this->redirect(['site/spasibo']);
            Yii::$app->end();
        }

        $souses = Dish::find()
                    ->where(['category_id' => 20])
                    ->andWhere(['id' => [135, 137, 133, 136]])
                    ->orderBy('sort')
                    ->all();

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