<?php

namespace backend\actions\products;

use Yii;
use backend\models\ApiHelper;

class CrossSell extends \yii\base\Action
{
    public function run()
    {
        $product_id = (int)Yii::$app->request->get('id');
        return ApiHelper::getProductCrossSell($product_id);
    }
}
