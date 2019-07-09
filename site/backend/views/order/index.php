<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="cart-order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?= Html::a("Обновить", ['order/index'], ['class' => 'btn btn-lg btn-primary', 'id' => 'refreshButton']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'status',
                'content' => function ($model) {
                    $statusText = $model->getStatus();
                    $labelClassName = $model->status === 0 ? 'label-danger' : 'label-success';
                    if ($model->status === 0) 
                    {
                        return '<span class="label label-danger" style="margin-bottom: 15px; display: inline-block;">' .
                                $statusText .
                                '</span><br><button data-role="order-confirm" data-id="' . $model->id . '" class="btn btn-success btn-xs">Принять</button>';
                    } else {
                        return '<span class="label label-success">' . $statusText . '</span>';
                    }
                }
            ],
            // 'phone',
            // 'email:email',
            [
                'attribute' => 'items',
                'content' => function ($model) {
                    $data = $model->compile();
                    $cost = 0;

                    $res = '';

                    foreach($data as $index => $item) 
                    {

                        $cost += $item['price'] * $item['quantity'];

                        $res .= '<p>';

                        $res .= '<b>' . $item['title'] . '</b>';

                        if (!empty($item['size'])) {
                            $res .= ' - ' . $item['size'];
                        }

                        $res .= ' - ' . $item['quantity'] . ' шт.';
                        $res .= ' - ' . $item['quantity'] * $item['price'] . ' руб. ('. $item['price'] .' за шт.)';

                        $res .= '</p>';
                    }

                    $res .= '<p> <b>Всего: '. $cost .' руб.</b></p>';
                    
                    return $res;
                }
            ],
            // [
            //     'attribute' => 'payment',
            //     'content' => function ($model) {
            //         return $model->getPaymentType();
            //     }
            // ],
            [
                'attribute' => 'details',
                'content' => function ($model) {
                    $res = '<table class="table">';

                    $res .= '<tr>' . 
                        '<td>Имя</td>' . 
                        '<td>' . Html::encode($model->name) . '</td>' . 
                        '</tr>';

                    $res .= '<tr>' . 
                        '<td>Телефон</td>' . 
                        '<td>' . Html::encode($model->phone) . '</td>' . 
                        '</tr>';

                    $res .= '<tr>' . 
                        '<td>Улица</td>' . 
                        '<td>' . Html::encode($model->street) . '</td>' . 
                        '</tr>';

                    $res .= '<tr>' . 
                        '<td>Дом</td>' . 
                        '<td>' . Html::encode($model->house) . '</td>' . 
                        '</tr>';

                    $res .= '<tr>' . 
                        '<td>Код\Домофон</td>' . 
                        '<td>' . Html::encode($model->code) . '</td>' . 
                        '</tr>';
                    $res .= '<tr>' . 
                        '<td>Квартира</td>' . 
                        '<td>' . Html::encode($model->apartment) . '</td>' . 
                        '</tr>';
                    $res .= '<tr>' . 
                        '<td>Этаж</td>' . 
                        '<td>' . Html::encode($model->floor) . '</td>' . 
                        '</tr>';
                    $res .= '<tr>' . 
                        '<td>Подъезд</td>' . 
                        '<td>' . Html::encode($model->entrance) . '</td>' . 
                        '</tr>';
                    $res .= '<tr>' . 
                        '<td>Способ оплаты</td>' . 
                        '<td>' . Html::encode($model->getPaymentType()) . '</td>' . 
                        '</tr>';
                    $res .= '<tr>' . 
                        '<td>С какой суммы подготовить сдачу</td>' . 
                        '<td>' . Html::encode($model->change) . '</td>' . 
                        '</tr>';
                    $res .= '<tr>' . 
                        '<td>Комментарий</td>' . 
                        '<td>' . Html::encode($model->comment) . '</td>' . 
                        '</tr>';

                    $res .= '</table>';
                    $res .= '<p>' . Yii::$app->formatter->asDatetime($model->created_at) . '</p>';

                    return $res;
                }
            ],
            // 'street',
            // 'house',
            // 'code',
            // 'change',
            // 'apartment',
            // 'floor',
            // 'entrance',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<audio id="play" style="display: none;" controls>
  <source src="/statics/bell.mp3" type="audio/mpeg">
</audio>

<?php

$script = <<< JS
    $(document).on('click', '[data-role="order-confirm"]', function () {
        var id = $(this).data('id');

        var self = this;
        var label = $(this).prev().prev();

        $.ajax({
            url: '/backend/order/confirm',
            data: { id: id },
            method: 'POST',
            success: function (response) {
                label.removeClass('label-danger');
                label.addClass('label-success');
                label.text('Принят');
                self.remove();
            }
        });
    });


    function checkNewOrders() {
        var orders = $('.label.label-danger');
        if (orders.length > 0) {
        var player = document.getElementById('play');
            player.play();
            notifyMe();
        }
    }

    function notifyMe() {

        var options = {
            sound: '/statics/bell.mp3',
            silent: false,
            tag: 'renotify',
            renotify: true
        };

        if (!("Notification" in window)) {
            alert("This browser does not support desktop notification");
        }

        else if (Notification.permission === "granted") {
            var notification = new Notification("Новый заказ!", options);
        }

        else if (Notification.permission !== 'denied') {
            Notification.requestPermission(function (permission) {
            if (permission === "granted") {
                var notification = new Notification("Новый заказ!", options);
            }
            });
        }
    }
    
    setInterval(function(){ 
        $("#refreshButton").click();
        setTimeout( checkNewOrders, 2000);
    }, 30 * 1000); // Раз в 1 минуту

    setInterval(checkNewOrders, 30 * 1000);

    checkNewOrders();

JS;
$this->registerJs($script, yii\web\View::POS_READY);

?>
