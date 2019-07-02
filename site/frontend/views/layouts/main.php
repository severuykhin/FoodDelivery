<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\models\Category;
use frontend\widgets\Cart;
use frontend\components\Cart as CartComponent;
use yii\helpers\Json;

$categories = Category::find()->orderBy(['sort' => SORT_DESC])->asArray()->all();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= $this->title ?></title>
    <?php $this->head() ?>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta charset="UTF-8">
    <meta name="yandex-verification" content="f2d8219c1de3abe8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css">
    <link rel="icon" href="/statics/favicon.ico">
    <link rel="canonical" href="<?= Url::canonical() ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="/statics/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/statics/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/statics/favicon-16x16.png">
    <link rel="icon" type="image/png" href="/statics/favicon.png" />
    <link rel="stylesheet" href="/statics/styles4.css">
    <script src="https://www.googletagmanager.com/gtag/js?id=UA-138651791-1"></script>
    <script>
        window.addEventListener('load', function () {
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-138651791-1');
            if (!document.referrer || document.referrer.split('/')[2].indexOf(location.hostname) != 0) {
                setTimeout(function() { gtag('event', 'pageview'); }, 15000);
            }
        });
    </script>

    <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter47772808 = new Ya.Metrika({ id:47772808, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/47772808" style="position:absolute; left:-9999px;" alt="" /></div></noscript> 
    <!-- /Yandex.Metrika counter -->

    <?= Html::csrfMetaTags() ?>
</head>
<body>
<!-- HEADER -->
<div class="header">
      <div class="header-wrapper">
        <div class="container-fluide">
          <div class="header__container">
            <a class="logo" href="/"> 
              <img class="logo__main" src="/statics/images/logo.png" alt="Кафе Шумовка Киров">
            </a>
            <?= Html::a('Наше меню', ['/menu'], ['class' => 'header__menu']);?>
              <div class="menu">

                

                <div class="menu__item menu__item-dropdown"> 
                <?= Html::a('Наше меню', ['menu/category', 'slug' => 'all'], ['class' => 'menu__item-link'])?>
                  <div class="menu__submenu">
                    <?php foreach($categories as $category): ?>
                    <?= Html::a(
                      $category['title'], 
                      [
                        'menu/category', 'slug' => $category['slug']
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
              <?= Cart::widget(); ?>
              <div class="button__menu" data-role="toggle-menu">
                <div></div>
                <div></div>
                <div></div>
              </div>
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
            <a class="social__button social__button-vk" target="_blank" rel="noopener nofollow" href="https://vk.com/shymovka_cafe"></a>
            <a class="social__button social__button-inst" target="_blank" rel="noopener nofollow" href="https://www.instagram.com/shymovka_cafe/?hl=ru"></a>
          </div>
        </div>
      </div>
    </footer>

    <script>
      window.initialData = <?= Json::encode(CartComponent::actualize()) ?> 
    </script>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
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
    <script src="/statics/libs2.js"></script>
    <script src="/statics/main4.js"></script>
</body>
</html>
<?php $this->endPage() ?>
