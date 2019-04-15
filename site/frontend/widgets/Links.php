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
            ->orderBy(['sort' => SORT_DESC])
            ->all();

        return $this->render('links', ['categories' => $categories]);
    }
}