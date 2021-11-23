#!/usr/bin/php
<?php

require "includes/CrawlerFunciton.php";
require "includes/ZhTranslation.php";
require "includes/Product.php";
require "includes/ShopeeProduct.php";

use crawler\shopee\includes\CrawlerFunction;
use crawler\shopee\includes\ProductCollection;
use crawler\shopee\includes\ZhTranslation;
use crawler\shopee\includes\ShopeeProduct;
use crawler\shopee\includes\ShopeeUrlArgs;

$now = date("Y-m-d");
$limit = 60;
$newest = 0;
$categoryId = '11041645';
$url = 'https://shopee.tw/api/v4/search/search_items';

$page = 1;
do {
    // 設定蝦皮 API 的參數
    $shopeeUrlArgs = new ShopeeUrlArgs($categoryId, $limit, $newest);
    $args = $shopeeUrlArgs->getArgs();
    // 執行爬蟲
    $crawler = new CrawlerFunction($url);
    $crawler->start(CrawlerFunction::ALLOWED_HTTP_METHOD_GET, $args);
    $response = $crawler->getResponse();
    $items = $response['items'];
    $productCollection = new ProductCollection();
    foreach ($items as $item) {
        $shopeeProducts = new ShopeeProduct();
        if (!isset($totalCount)) { // 至少要執行一次才抓得到總筆數
            $productCollection->setTotalCount($response[ShopeeProduct::FIELD_TOTAL_COUNT]);
            $totalCount = 120; //$productCollection->getTotalCount();
        }
        $shopeeProducts
            ->setPrice($item[ShopeeProduct::RESPONSE_KEY][ShopeeProduct::FIELD_PRICE])
            ->setTitle($item[ShopeeProduct::RESPONSE_KEY][ShopeeProduct::FIELD_TITLE], ZhTranslation::TRANSLATE_TRAD_TO_SIMP);
        $productCollection->setProductToItems($shopeeProducts);
        $items = $productCollection->getItems();
    }
    $productCollection->save($items, "./products/$now-results-$page.json");
    $newest += $limit;
    $page++;
    sleep(rand(1, 3));
} while ($newest <= $totalCount);
