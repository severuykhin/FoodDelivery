<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\CartOrder;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

$labelMap = [
    0 => 'label-danger',
    1 => 'label-success',
    2 => 'label-warning',
    3 => 'label-warning'
];

$stateClassMap = [
    0 => 'has-error',
    1 => 'has-success',
    2 => 'has-warning',
    3 => 'has-warning'
];

?>


<div class="cart-order-index">

    <style>
        .order-label {
            margin-right: 10px;
            margin-top: 6px; 
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }

        .order-status {
            display: inline-block;
            vertical-align: top;
        }

        .label:empty {
            display: inline-block !important;
        }
    </style>

    <script>
        window.labelClassMap = <?= json_encode($labelMap) ?>;
        window.stateClassMap = <?= json_encode($stateClassMap) ?>;
    </script>

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
                'headerOptions' => [
                    'style' => 'width: 161px'
                ],
                'content' => function ($model) use ($labelMap, $stateClassMap) {
                    $statusText = $model->getStatus();
                    $labelClassName = $labelMap[$model->status];
                    $stateClassName = $stateClassMap[$model->status];
                    
                    $dropDown = '<div class="order-status form-group '. $stateClassName .'">' . Html::dropDownList(
                            'CartOrder[status]', 
                            $model->status, 
                            CartOrder::getStatuses(), [
                                'data-id' => $model->id,
                                'data-role' => 'order-status-select',
                                'class' => 'form-control has-error',
                            ]) . '</div>';

                    $printBtn = Html::button('Распечатать', 
                        [
                        'class' => 'btn btn-xs btn-default', 
                        'data-id' => $model->id,
                        'data-role' => 'print-order',
                        'data-toggle'=> 'modal',
                        'data-target' => '#modal'
                        ]);

                    return '<span class="order-label label '. $labelClassName .'">' .
                            '</span>' . $dropDown . $printBtn;
                }
            ],
            // 'phone',
            // 'email:email',
            [
                'attribute' => 'items',
                'content' => function ($model) {
                    $data = $model->compile();
                    $cost = 0;
                    $freeSousAmount = $model->getFreeSousAmount();
                    $has_no_action_products = false;

                    $res = '';

                    foreach($data as $index => $item) 
                    {

                        if ($item['act_in_action'] == 0) {
                            $has_no_action_products = true;
                        }

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

                    if ($freeSousAmount) {
                        $cost = $cost - ($freeSousAmount * 30);
                        $res .= '<hr>';
                        $res .= "<p><b>Соусы</b>: $freeSousAmount бесплатно</p>";
                    }

                    if ($cost >= 950 && $model->created_at > 1566930000 && $has_no_action_products == false) {
                        $res .= '<hr>';
                        $res .= "<p><b>Подарок</b>: Пицца с салями и моцареллой 40 см - 1 шт.</p>";
                    }

                    $res .= '<hr>';
                    $res .= '<p> <b>Итого к оплате: '. $cost .' руб.</b></p>';

                    
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

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {delete}'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<audio id="play" style="display: none;" controls>
  <source src="/statics/bell.mp3" type="audio/mpeg">
</audio>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Распечатать заказ</h4>
      </div>
      <div class="modal-body">
        <iframe style="width:100%; height: 1000px;" data-role="print-iframe" src="" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<?php

$script = <<< JS
    $(document).on('change', '[data-role="order-status-select"]', function () {

        var elem = $(this),
            id = elem.data('id'),
            statusId = parseInt(elem.val(), 10),
            formGroup = elem.parent(),
            label = formGroup.prev(),
            labelClass = window.labelClassMap[statusId],
            selectClass = window.stateClassMap[statusId];

        $.ajax({
            url: '/backend/order/state',
            data: { id: id, status: statusId },
            method: 'POST',
            success: function (response) {

                if (response !== 'ok') {
                    alert('Ошибка: ' + response);
                    return;
                }

                label.attr(
                    'class',
                    label.attr('class').replace(/label-\S+/g, labelClass)
                );

                formGroup.attr(
                    'class',
                    formGroup.attr('class').replace(/has-\S+/g, selectClass)
                );
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

    $('[data-role="print-order"]').on('click', function () {
        let id = $(this).data('id');
        $('[data-role="print-iframe"]').attr('src', '/backend/order/print?' + 'id=' + id)
    });

JS;
$this->registerJs($script, yii\web\View::POS_READY);

?>
