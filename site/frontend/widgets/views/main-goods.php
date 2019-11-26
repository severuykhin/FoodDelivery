<div class="container-fluide">
    <div class="store__inner">

        <?php foreach($categories as $index => $category): ?>
            <div class="store__category">
                <h2 class="title_category">
                    <?= $category->title ?>
                </h2>
            </div>
            <div class="store__items">
                <?php foreach($category->dishes as $index => $item):?>

                    <?= $this->render('../../views/menu/_item', [
                        'item'          => $item,
                        'categoryTitle' => $category->title,
                        'categorySlug'  => $category->slug,
                        'categoryId'    => $category->id,
                        'index' => $index
                    ]);?>

                <?php endforeach;?>
            </div>
        <?php endforeach; ?>

    </div>
</div>  