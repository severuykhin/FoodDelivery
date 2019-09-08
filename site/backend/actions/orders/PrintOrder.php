<?php

namespace backend\actions\orders;

use Yii;
use common\models\CartOrder;

class PrintOrder extends \yii\base\Action
{
    public function run($id)
    {

        $order = CartOrder::findOne(['id' => $id]);

        if (!$order) {
            return 'Заказ не найден';
        }

        $html = $this->controller->renderPartial('_print', [
            'model' => $order
        ]);

        return $html;
    }
}
