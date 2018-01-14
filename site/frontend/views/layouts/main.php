<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css">
    <link rel="icon" href="/statics/favicon.ico">
    <link rel="apple-touch-icon" sizes="60x60" href="/statics/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/statics/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/statics/favicon-16x16.png">
    <link rel="icon" type="image/png" href="/statics/favicon.png" />
    <link rel="stylesheet" href="/statics/styles.css">
    <title>Кафе Шумовка - еда на вынос и не только</title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<!-- HEADER -->
<div class="header">
      <div class="container-fluide">
        <div class="header__container">
          <div class="button__menu" data-role="toggle-menu">
            <div></div>
            <div></div>
            <div></div>
          </div>
          <a class="logo" href="/"> 
            <img class="logo__main" src="/statics/images/logo.png" alt="Кафе Шумовка Киров">
          </a>
          <?= Html::a('Доставка', ['/menu'], ['class' => 'header__menu']);?>
            <div class="menu">

              <div class="menu__item"> 
                <?= Html::a('Главная', ['/'], ['class' => 'menu__item-link'])?>
              </div>

              <div class="menu__item menu__item-dropdown"> 
              <?= Html::a('Меню', ['/menu#all'], ['class' => 'menu__item-link'])?>
                <div class="menu__submenu">
                  <?php foreach($categories as $category): ?>
                  <?= Html::a(
                    $category['title'], 
                    [
                      '/menu#' . $category['slug']
                    ], 
                    [
                      'class' => 'menu__subitem',
                      'title' => 'Заказать ' . $category['title']
                    ]);?>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="menu__item"> 
                <?= Html::a('О нас', ['/about'], ['class' => 'menu__item-link'])?>
              </div>

              <div class="menu__item"> 
                <?= Html::a('Контакты', ['/contacts'], ['class' => 'menu__item-link'])?>
              </div>

            </div>
            <div class="header__work">
            <div class="header__work-item">Ежедневно с 10:00 - 22:00</div>
            <a class="header__work-item header__work-bold" href="tel:+78332416646">+7-(8332)-41-66-46</a>
            </div>
            <div class="header__icons">
              <a class="header__phone" href="tel:+78332416646">
              <svg version="1.1" fill="#54a101" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="348.077px" height="348.077px" viewbox="0 0 348.077 348.077" style="enable-background:new 0 0 348.077 348.077;" xml:space="preserve">
                <g>
                  <g>
                    <g>
                      <path d="M340.273,275.083l-53.755-53.761c-10.707-10.664-28.438-10.34-39.518,0.744l-27.082,27.076                    c-1.711-0.943-3.482-1.928-5.344-2.973c-17.102-9.476-40.509-22.464-65.14-47.113c-24.704-24.701-37.704-48.144-47.209-65.257                   c-1.003-1.813-1.964-3.561-2.913-5.221l18.176-18.149l8.936-8.947c11.097-11.1,11.403-28.826,0.721-39.521L73.39,8.194                    C62.708-2.486,44.969-2.162,33.872,8.938l-15.15,15.237l0.414,0.411c-5.08,6.482-9.325,13.958-12.484,22.02                   C3.74,54.28,1.927,61.603,1.098,68.941C-6,127.785,20.89,181.564,93.866,254.541c100.875,100.868,182.167,93.248,185.674,92.876                   c7.638-0.913,14.958-2.738,22.397-5.627c7.992-3.122,15.463-7.361,21.941-12.43l0.331,0.294l15.348-15.029                    C350.631,303.527,350.95,285.795,340.273,275.083z"></path>
                    </g>
                  </g>
                </g>
              </svg>
            </a>
              <a class="header__pin" href="<?= Url::toRoute(['site/contacts']) ?>" title="Кафе Шумовка - контакты">
              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                <g>
                  <g>
                    <path d="m64.5,6.4c-25.5,0-46.3,20.8-46.3,46.4-3.55271e-15,3.1 0.3,6.2 0.9,9.2 0,0.2 0.1,0.4 0.1,0.7 5.1,22.9 41,57.3 42.5,58.7 0.8,0.8 1.8,1.1 2.8,1.1 1,0 2-0.4 2.8-1.1 1.5-1.5 37.2-35.8 42.3-58.2 0-0.2 0.1-0.4 0.1-0.6 0.7-3.2 1-6.5 1-9.8 0.1-25.6-20.7-46.4-46.2-46.4zm37.2,54.7c0,0.2 0,0.1 0,0.3-3.8,16.6-28.7,42.8-37.2,51.3-8.5-8.5-33.5-34.7-37.3-51.7 0-0.2 0-0.3-0.1-0.5-0.5-2.6-0.8-5.2-0.8-7.8 0-21 17.1-38.2 38.1-38.2 21,0 38.2,17.1 38.2,38.2-1.42109e-14,2.9-0.3,5.7-0.9,8.4z"></path>
                    <path d="m64.5,32.5c-8.6,0-15.5,7-15.5,15.5s7,15.5 15.5,15.5 15.5-6.9 15.5-15.5-6.9-15.5-15.5-15.5zm0,22.9c-4.1,0-7.4-3.3-7.4-7.4s3.3-7.4 7.4-7.4c4.1,0 7.4,3.3 7.4,7.4s-3.3,7.4-7.4,7.4z"></path>
                  </g>
                </g>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
<!-- HEADER END -->
    <?php $this->beginBody() ?>
        <div class="content">
            <?= $content ?>
        </div>
    <?php $this->endBody() ?>
    <footer class="footer">
      <div class="container">
        <div class="footer__inner">
          <a class="footer__logo" href="/">
            <img src="/statics/images/logo.png" alt="Шумовка - доставка еды в Кирове">
          </a>
          <div class="footer__menu">
            <?= Html::a('Главная', ['/'], ['class' => 'footer__menu-item']);?>
            <?= Html::a('Меню', ['/menu'], ['class' => 'footer__menu-item']);?>
            <?= Html::a('О нас', ['/about'], ['class' => 'footer__menu-item']);?>
            <?= Html::a('Контакты', ['/contacts'], ['class' => 'footer__menu-item']);?>
          </div>
          <div class="social">
            <span class="social__caption">Мы с социальных сетях:</span>
            <a class="social__button social__button-vk" href=""></a>
            <a class="social__button social__button-inst" href=""></a>
          </div>
        </div>
      </div>
    </footer>


    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
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
