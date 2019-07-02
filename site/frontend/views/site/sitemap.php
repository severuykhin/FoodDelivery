<?php

$content = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$content .= "<url>
        <loc>https://shymovka43.ru</loc>
        <lastmod>2019-05-03</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1</priority>
    </url>";

foreach($categories as $category)
{   
    $date = Yii::$app->formatter->asDate(time(), 'yyyy-MM-dd');
    $content .= "<url>
        <loc>https://shymovka43.ru/menu/$category->slug</loc>
        <lastmod>$date</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>";
}

$content .= "<url>
        <loc>https://shymovka43.ru/about</loc>
        <lastmod>2019-05-03</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.60</priority>
    </url>";

$content .= "<url>
    <loc>https://shymovka43.ru/contacts</loc>
    <lastmod>2019-05-03</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.60</priority>
</url>";

$content .= "<url>
    <loc>https://shymovka43.ru/reviews</loc>
    <lastmod>2019-05-03</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.60</priority>
</url>";


$content .= '</urlset>';
echo $content;