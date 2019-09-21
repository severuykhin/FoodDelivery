<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\Category;

/* *
 * @class SeoActiveLinks - represent active content semantic link-tags
 * @private $links = array
 * */
class SeoActiveLinks extends Widget
{

    private $links = [
        [
            'slug' => 'picca',
            'name' => 'Доставка аппетитной пиццы в Кирове'
        ],
        [
            'slug' => 'rolly',
            'name' => 'Заказать роллы с доставкой'
        ],
        [
            'slug' => 'goracie-bluda',
            'name' => 'Доставка вкусных обедов в офис'
        ],
        [
            'slug' => 'firmennaa-lapsa',
            'name' => 'Заказать лапшу Киров'
        ],
        [
            'slug' => 'deserty',
            'name' => 'Заказать десерты Киров'
        ],
        [
            'slug' => 'cebureki',
            'name' => 'Доставка хрустящих чебуреков Киров'
        ],
        [
            'slug' => 'supy',
            'name' => 'Заказать обед в офис'
        ]
    ];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('seo_active_links', ['links' => $this->links]);
    }
}