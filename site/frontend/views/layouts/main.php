<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\models\Category;
use frontend\widgets\Cart;
use frontend\components\Cart as CartComponent;
use yii\helpers\Json;

$categories = Category::find()->where(['<>', 'id', 20])->orderBy(['sort' => SORT_DESC])->asArray()->all();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= $this->title ?></title>
    <?php $this->head() ?>
    <meta charset="<?= Yii::$app->charset ?>"/>
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
    <link rel="stylesheet" href="/statics/styles.css">

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

    <!-- Yandex.Metrika counter -->
    <script>
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(47772808, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true,
            trackHash:true
        });
    </script>
    <!-- /Yandex.Metrika counter -->

    <?= Html::csrfMetaTags() ?>
</head>
<body>
<!-- HEADER -->
<header class="header">
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
                <div class="menu__item hidden-md-up"> 
                  <a class="menu__item-link menu__item-link_accent" href="tel:+78332416646">+7 (8332) 41-66-46</a>
                </div>
                <div class="menu__item  hidden-md-up"> 
                    <span class="menu__item-link  menu__item-link_accent">ул. Калинина д. 40</span>
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
      <div class="header__mobile-nav hidden-lg-up" data-role="header-mobile-nav">
        <div class="header__mobile-nav-wrap">
          <ul class="header__mobile-links">
                <?php foreach($categories as $category): ?>
                <?php $isActive = Yii::$app->request->get('slug') === $category['slug'] ?>
                <li class="header__mobile-links-item">
                  <?= Html::a(
                    $category['title'], 
                    [
                      'menu/category', 'slug' => $category['slug']
                    ], 
                    [
                      'class' => 'header__mobile-links-link' . ($isActive ? ' active' : ''),
                      'title' => 'Заказать ' . $category['title']
                    ]);?>
                </li>
                <?php endforeach; ?>
          </ul>
        </div>
      </div>
</header>
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
            <span class="social__caption">Мы в социальных сетях:</span>
            <a class="social__button social__button-vk" target="_blank" rel="noopener nofollow" href="https://vk.com/shymovka_cafe"></a>
            <a class="social__button social__button-inst" target="_blank" rel="noopener nofollow" href="https://www.instagram.com/shymovka_cafe/?hl=ru"></a>
          </div>
        </div>
      </div>
    </footer>

    <script>
      window.initialData = <?= Json::encode(CartComponent::actualize()) ?> 
    </script>

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
    <script src="/statics/libs.js"></script>
    <script src="/statics/main.js"></script>
</body>
</html>
<?php $this->endPage() ?>
