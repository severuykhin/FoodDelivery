<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\Category;

class MainGoods extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {

        $categories = Category::find()
                        ->with(['dishes'])
                        ->orderBy(['sort' => SORT_DESC])
                        ->limit(6)
                        ->all();

        return $this->render('main-goods', [
            'categories' => $categories
        ]);
    }
}