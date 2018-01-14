<div class="content__block">
    <div class="container">
        <div class="reviews">
            <div class="reviews__title">
                <h1>Отзывы наших гостей</h2>
            </div>
            <div class="reviews__inner">
            <a class="reviews__item reviews__item-feedback" href="https://vk.com/topic-124087268_36102081">
                <div class="reviews__item-feed">Оставьте свой отзыв в нашей группе ВКонтакте</div>
                <img class="reviews__item-vk" src="/statics/images/vk.svg" target="_blank">
            </a>
            <?= $this->render('_reviews', [
                'reviews' => $reviews
            ]);?>
            </div>
        </div>
    </div>
</div>