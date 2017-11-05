<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\models\Category;

$categories = Category::find()->orderBy(['sort' => SORT_DESC])->asArray()->all();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="/statics/styles.css">
    <title>Шумовка - еда на вынос</title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<!-- HEADER -->
<div class="header">
      <div class="container-fluide">
        <div class="header__container"><a class="logo" href="#"> <img class="logo__main" src="/statics/images/logo.png" alt="Кафе Шумовка Киров"></a>
          <div class="menu__wrapper">
            <div class="menu">
              <div class="menu__item"> <a class="menu__item-link" href="/">Главная</a></div>
              <div class="menu__item menu__item-dropdown"> 
              <?= Html::a('Меню', ['/menu'], ['class' => 'menu__item-link'])?>
                <div class="menu__submenu">
                  <?php foreach($categories as $category): ?>
                  <?= Html::a(
                    $category['title'], 
                    [
                      'menu/' . $category['slug']
                    ], 
                    [
                      'class' => 'menu__subitem',
                      'title' => 'Заказать ' . $category['title']
                    ]);?>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="menu__item"> <a class="menu__item-link" href="#">О нас</a></div>
              <div class="menu__item"> <a class="menu__item-link" href="#">Контакты</a></div>
            </div>
            <div class="contacts"><a class="contacts__item contacts__geo" href="#" title="Посмотреть на карте -- ссылка на контакты"><span>Калинина 40</span></a></div>
            <div class="contacts"><a class="contacts__item contacts__phone" href="tel:+78332416646" title="Позвонить в кафе Шумовка"> <span>+7-(8332)-41-66-46</span></a></div>
          </div>
        </div>
      </div>
    </div>
<!-- HEADER END -->
    <?php $this->beginBody() ?>

        <?= $content ?>

    <?php $this->endBody() ?>


    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
      !function (i,s,o,g,r,a,m) {
          if (typeof window[g] === "undefined") {
              var script = s.createElement("script");
              var node   = s.getElementsByTagName("script")[0];
              script.src = o;
              script.type = "text/javascript";
              node.parentNode.insertBefore(script, node);
          }
      }(window, document, "js/jquery.min.js", "jQuery");
    </script>
    <!-- /подключение jquery-->
    <script src="/statics/main.js"></script>
</body>
</html>
<?php $this->endPage() ?>
