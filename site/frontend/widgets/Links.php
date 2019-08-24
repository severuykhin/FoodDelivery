<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\Category;

class Links extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {

        $categories =  Category::find()
            ->where(['<>', 'id', 20])
            ->orderBy(['sort' => SORT_DESC])
            ->all();

        return $this->render('links', ['categories' => $categories]);
    }
}