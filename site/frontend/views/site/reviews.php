<div class="content__block">
    <div class="container">
        <div class="reviews">
            <div class="reviews__title">
                <h1>Отзывы наших гостей</h2>
            </div>

            <?= $this->render('_reviews', [
                'reviews' => $reviews
            ]);?>

        </div>
    </div>
</div>