<?php

namespace frontend\components;

use Yii;
use common\models\Cart as CartModel;
use yii\base\Component;
use yii\web\NotFoundHttpException;
use yii\helpers\VarDumper;

class Cart extends Component 
{

    public function init()
    {

        $session = Yii::$app->session;

        if ( !$session->isActive) { $session->open(); }

        $sessionId = Yii::$app->request->cookies['cart_id'];
        $cart = CartModel::find()->where(['session_id' => $sessionId])->exists();

        if (!$sessionId || !$cart) {

            $current_session_id = Yii::$app->session->getId(); 

            $cart = new CartModel();
            $cart->session_id = $current_session_id;
            $cart->save();

            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name'  => 'cart_id',
                'value' => $current_session_id,
                'path'  => '/',
                'expire' => time() + 86400 * 365,
                'httpOnly' => false
            ]));
        }
    }

    public static function getInstance()
    {
        $sessionId = Yii::$app->request->cookies['cart_id'];
        $cart = CartModel::find()->where(['session_id' => $sessionId])->one();

        if (!$cart) {
            return null;
        }

        return $cart;
    }

    public static function actualize()
    {
        $cart = self::getInstance();

        if (!$cart) return [
            'items' => [],
            'bonuses' => []
        ];

        return [
            'items' => $cart->getActualItems(),
            'bonuses' => $cart->getActualBonues()
        ];
    }
}