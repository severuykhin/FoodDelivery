<?php  

use yii\helpers\VarDumper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Корзина';

$referrerIsSameOrigin = stripos(Yii::$app->request->referrer, 'shymovka') !== false || stripos(Yii::$app->request->referrer, 'shumovka'); // With test env

?>

<div class="container-cart">

<br>
<br class="hidden-md-down">

<?php if($referrerIsSameOrigin): ?>
    <a onclick="javascript:history.back();" class="cart-page__back">Назад</a>
<?php endif; ?>

<h1 class="title title-h1 title-cart">
Корзина
</h1>

    <div class="cart-page" data-role="cart-page">
        
    </div>

    <div class="cart-order" data-role="cart-order-form" style="display: none;">

    <h2 class="title cart-order__title">Оформление заказа</h2>

    <div class="cart-order__form">

    <?php $form = ActiveForm::begin(['options' => [
        'data-role' => 'cart-order'
    ]]); ?>
        <div class="row" style="margin-bottom: 30px;"> 
            <div class="col-lg-6 error-left">
                <?= $form->field($order, 'name')->textInput([
                    'class' => 'cart-order__input',
                    'placeholder' => 'Ваше имя*'
                ])->label(false); ?>
            </div>
            <div class="col-lg-6 error-right">
                <?= $form->field($order, 'phone')->textInput([
                    'class' => 'cart-order__input',
                    'placeholder' => 'Ваш телефон*',
                    'data' => [
                        'phone' => true
                    ]
                ])->label(false); ?>
            </div>
        </div>
        <div class="row" style="margin-bottom: 30px;">

            <div class="col-lg-6 error-left">
                <?= $form->field($order, 'street')->textInput([
                    'class' => 'cart-order__input',
                    'placeholder' => 'Улица*'
                ])->label(false); ?>
            </div>
            <div class="col-lg-3 error-right">
                <?= $form->field($order, 'house')->textInput([
                    'class' => 'cart-order__input',
                    'placeholder' => 'Дом*'
                ])->label(false); ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($order, 'apartment')->textInput([
                    'class' => 'cart-order__input',
                    'placeholder' => 'Квартира'
                ])->label(false); ?>
            </div>

        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-lg-4 error-left">
                <?= $form->field($order, 'entrance')->textInput([
                    'class' => 'cart-order__input',
                    'placeholder' => 'Подъезд'
                ])->label(false); ?>
            </div>
            <div class="col-lg-4 cart-order-code error-left">
                <?= $form->field($order, 'code')->textInput([
                    'class' => 'cart-order__input',
                    'placeholder' => 'Код двери'
                ])->label(false); ?>
                <span class="cart-order__dom" data-role="cart-order-dom">Домофон</span>
            </div>
            <div class="col-lg-4 error-left">
                <?= $form->field($order, 'floor')->textInput([
                    'class' => 'cart-order__input',
                    'placeholder' => 'Этаж'
                ])->label(false); ?>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <h5 style="margin-bottom: 20px;">Дополнительная информация</h5>
            </div>
            <div class="col-lg-5">
                <?= $form->field($order, 'payment')->dropDownList(
                    ['Наличными курьеру', 'Картой курьеру']
                )->label(false); ?>
            </div>
            <div class="col-lg-7">
                <?= $form->field($order, 'change')->textInput([
                    'class' => 'cart-order__input',
                    'placeholder' => 'С какой суммы подготовить сдачу'
                ])->label(false); ?>
            </div>
            <div class="col-lg-12" style="margin-top: 30px;">
                <?= $form->field($order, 'comment')->textArea([
                    'class' => 'cart-order__input cart-order__textarea',
                    'placeholder' => 'Комментарий с заказу'
                ])->label(false); ?>
            </div>
            <div class="col-lg-12">
                <div class="cart-order__notice">
                        <b>Внимание, примите к сведению:</b><br>
                        В случае, если мы не смогли до Вас дозвонится для подтверждения, Ваш заказ будет аннулирован.
                </div>
            </div>
            <div class="col-lg-12 cart-order__actions">
                <?= Html::submitButton('Заказать', [
                    'class' => 'button button__primary button__form'
                ]) ?>
            </div>

        </div>
    <?php ActiveForm::end(); ?>

    </div>

    </div>

    <div class="cart-stub" style="display: none;" data-role="cart-order-stub">
        Минимальная сумма заказа - 450 руб.
    </div>

</div>