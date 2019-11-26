<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\CartOrder;
use common\models\Category;
use Yii;

class SortController extends Controller
{
    public function actionIndex()
    {
        $products = CartOrder::getDishSummary();
        $categories = Category::find()->all();

        $categories_map = [];

        foreach($products as $product)
        {
            if (!isset($product['c_id'])) {
                continue;
            }

            if (!isset($categories_map[$product['c_id']])) {
                $categories_map[$product['c_id']] = [];
            }

            $categories_map[$product['c_id']][$product['product_id']] = (int) $product['quantity'];
        }   

        foreach($categories_map as $index => $category)
        {
            asort($categories_map[$index]);
            $categories_map[$index] = array_combine( 
                                        array_keys( $categories_map[$index] ), 
                                        array_reverse( array_values( $categories_map[$index] ) ) 
                                    );

            $product_queue = [];

            foreach($categories_map[$index] as $p_id => $quantity)
            {
                $product_queue[] = $p_id;
            } 

            foreach($product_queue as $sort_index => $product_id) 
            {
                Yii::$app->db->createCommand()->update('dish', [
                   'sort' => $sort_index + 1 
                ], 'id = ' . $product_id)->execute();
            }
        }
    }
}