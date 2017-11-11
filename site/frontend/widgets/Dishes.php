<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;

class Dishes extends Widget
{
    public $items;

    public function init()
    {
        parent::init();
        if ($this->items === null) {
            $this->items = 'Ничего не нашлось :(';
        }
    }

    public function run()
    {
        return $this->render('dishes', [
            'items' => $this->items
        ]);
    }
}