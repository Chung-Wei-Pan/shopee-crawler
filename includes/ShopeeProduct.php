<?php

namespace crawler\shopee\includes;

require "UrlArgs.php";

class ShopeeProduct extends Product
{
    // 設定蝦皮 API 回傳的陣列欄位名稱為常數
    const RESPONSE_KEY = "item_basic";
    const FIELD_TOTAL_COUNT = 'total_count';
    const FIELD_PRICE = 'price';
    const FIELD_TITLE = 'name';
    const FIELD_PRODUCT_ITEMS = 'items';

    public function setPrice($price)
    {
        // 蝦皮 API 的產品價格是實際標價的 100000 倍
        return parent::setPrice($price / 100000);
    }
}


class ShopeeUrlArgs extends UrlArgs
{
    // 設定蝦皮 API 網址需帶的參數
    const FIELD_BY = 'by';
    const FIELD_CATEGORY_ID = 'fe_categoryids';
    const FIELD_ORDER = 'order';
    const FIELD_PAGE_TYPE = 'page_type';
    const FIELD_SCENARIO = 'scenario';
    const FIELD_VERSION = 'version';
    const FIELD_LIMIT = 'limit';
    const FIELD_NEWEST = 'newest';
    // 預設欄位
    public $by = "relevancy";
    public $order = "desc";
    public $pageType = "search";
    public $scenario = "PAGE_OTHERS";
    public $version = 2;

    // 需另外設定欄位
    private $categoryId;


    public function __construct($categoryId, $limit, $newest)
    {
        parent::__construct($limit, $newest);
        $this->categoryId = $categoryId;
        $this->setArgs();
    }

    public function setArgs()
    {
        $this->args = [
            self::FIELD_BY => $this->by,
            self::FIELD_CATEGORY_ID => $this->categoryId,
            self::FIELD_ORDER => $this->order,
            self::FIELD_PAGE_TYPE => $this->pageType,
            self::FIELD_SCENARIO => $this->scenario,
            self::FIELD_VERSION => $this->version,
            self::FIELD_LIMIT => $this->limit,
            self::FIELD_NEWEST => $this->newest,
        ];
        return $this;
    }
}
