<?php

use yii\helpers\Html;

$data = $model->compile();
$cost = 0;
$freeSousAmount = $model->getFreeSousAmount();

?>

<p>
    <strong>Ваше имя: </strong><span><?= $model->name ?></span>
</p>

<p>
    <strong>Телефон: </strong>
    <span><?= $model->phone ?></span>
</p>

<p>
    <strong>Улица: </strong>
    <span><?= $model->street ?></span>
</p>

<p>
    <strong>Дом: </strong>
    <span><?= $model->house ?></span>
</p>

<p>
    <strong>Квартира: </strong>
    <span><?= $model->apartment ?></span>
</p>

<p>
    <strong>Подъезд: </strong>
    <span><?= $model->entrance ?></span>
</p>

<p>
    <strong>Код/домофон: </strong>
    <span><?= $model->code ?></span>
</p>

<p>
    <strong>Этаж: </strong>
    <span><?= $model->floor ?></span>
</p>

<p>
    <strong>Способ оплаты: </strong>
    <span><?= $model->getPaymentType() ?></span>
</p>

<p>
    <strong>С какой суммы нужна сдача: </strong>
    <span><?= $model->change ?></span>
</p>

<p>
    <strong>Комментарий к заказу: </strong>
    <span><?= $model->comment ?></span>
</p>

<p>
    <strong>Время заказа: </strong>
    <span><?= $model->getOrderTime() ?></span>
</p>
<br>
<h2>Подробности</h2>
<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td style="border: 1px solid #999;">№</td>
            <td style="border: 1px solid #999;">Наименование</td>
            <td style="border: 1px solid #999;">Модификация</td>
            <td style="border: 1px solid #999;">Количество</td>
            <td style="border: 1px solid #999;">Цена</td>
            <td style="border: 1px solid #999;">Стоимость</td>
        </tr>
    </thead>
    <tbody>
        <?php 
            $cost = 0; 
            $amount = 0;
            $has_no_action_products = false;



        ?>
        <?php foreach($data as $index => $item): ?>
            <?php 
                if ($item['act_in_action'] == 0) {
                    $has_no_action_products = true;
                }   
                $amount += $item['quantity'];
                $cost += $item['price'] * $item['quantity']; 
            ?>
            <tr>
                <td style="border: 1px solid #999;"><?= $index + 1 ?></td>
                <td style="border: 1px solid #999;"><?= $item['title'] ?></td>
                <td style="border: 1px solid #999;"><?= $item['size'] ?></td>
                <td style="border: 1px solid #999;"><?= $item['quantity'] ?></td>
                <td style="border: 1px solid #999;"><?= $item['price'] ?></td>
                <td style="border: 1px solid #999;"><?= $item['price'] * $item['quantity'] ?></td>
            </tr>
        <?php endforeach; ?>

        <?php 
            if ($freeSousAmount) {
                $cost = $cost - ($freeSousAmount * 30);
            }
        ?>
        <?php if($freeSousAmount): ?>
            <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td style="border: 1px solid #999;"></td>
                <td style="border: 1px solid #999;">Бесплатные соусы</td>
                <td style="border: 1px solid #999;"></td>
                <td style="border: 1px solid #999;"><?= $freeSousAmount ?></td>
                <td style="border: 1px solid #999;">0</td>
                <td style="border: 1px solid #999;">-<?= $freeSousAmount * 30 ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td style="border: 1px solid #999;"></td>
            <td style="border: 1px solid #999;"></td>
            <td style="border: 1px solid #999;">Итого</td>
            <td style="border: 1px solid #999;"><?= $amount ?></td>
            <td style="border: 1px solid #999;"></td>
            <td style="border: 1px solid #999;"><?= $cost ?></td>
        </tr>
    </tbody>
</table>