<?php

namespace backend\actions\orders;

use Yii;
use backend\models\ApiHelper;

class OrderMap extends \yii\base\Action
{
    public function run()
    {
        $requestData = Yii::$app->request->get();
        return ApiHelper::getOrderMap($requestData);
    }
}
