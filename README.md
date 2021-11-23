# Shopee Crawler 蝦皮商品爬蟲

## 說明

本專案為蝦皮的商品分類爬蟲，會將指定分類的商品資訊抓至 `products/` 資料夾，並將商品名稱由繁體轉為簡體

## 使用

```bash
php -f ./crawler.php
```

- 需安裝 PHP 的 cURL 套件
- 繁體轉簡體使用 MediaWiki 提供的 ZhConversion.php 進行翻譯

## 檔案說明

### crawler.php

爬蟲的執行程式檔，執行商品爬取以及檔案儲存的工作。

```php
// 每一次撈的商品筆數
$limit = 60;
// 從哪一筆開始撈
$newest = 0;
// 商品的 category ID
$categoryId = '11041645';
// 要爬的 API Endpoint
$url = 'https://shopee.tw/api/v4/search/search_items';
```

### includes/

爬蟲相關的物件以及函數皆存放於此

#### lib/

- 儲存外部程式檔案

#### ZhTranslation.php

- 簡繁轉換程式碼

#### CrawlerFunction.php

- 設定目標網址
- 執行爬蟲、取得內容的函數

#### Product.php

包含兩個類別

1. Product

   - 為商品的基本屬性設定
   - 商品名稱的翻譯在此實作

2. ProductCollection

   - 儲存所有商品的資訊
   - 取得商品總筆數

#### UrlArgs.php

- 儲存網址基本參數的函數，包含每一頁數量以及開始爬取的商品
- 取得設定的參數內容

#### ShopeeProduct.php

內部共有兩個類別，分別繼承上述所寫的基本類別，因為蝦皮的 API Endpoint 有許多該平台特有的欄位名稱，因此將蝦皮獨立拉成一個類別，在後續若平台 API 更新時，爬蟲也較容易維護。

1. ShopeeProduct

   - 儲存蝦皮商品的基本屬性以及欄位名稱
   - 由於 API 與實際標價不同，因此需要重寫設定價格的父類別

2. ShopeeUrlArgs

   - 儲存蝦皮商品搜尋 API 的參數
   - 設定 API Endpoint 的參數
