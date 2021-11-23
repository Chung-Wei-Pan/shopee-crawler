<?php

namespace crawler\shopee\includes;

use crawler\shopee\includes\ZhTranslation;

class Product
{
    protected $price;
    protected $title;

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function setTitle($title, $translation = null)
    {
        $this->title = $title;
        if (!empty($translation)) {
            $zhTranslation = new ZhTranslation();
            $this->title = $zhTranslation->$translation($title);
        }
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getTitle()
    {
        return $this->title;
    }
}

class ProductCollection
{
    private static $items = [];
    private static $totalCount;

    public function __construct()
    {
        $this->items = [];
    }

    /**
     * 設定最後取得的結果
     * @param Product $product 商品
     * @return $this 
     */
    public function setProductToItems(Product $product)
    {
        $this->items[] = [
            "title" => $product->getTitle(),
            "price" => $product->getPrice()
        ];
        return $this;
    }

    /**
     * 將傳入商品存為 Json 檔案
     * @param array $items 商品陣列
     * @param string $path 儲存路徑
     * @return void 
     */
    public function save(array $items, $path)
    {
        $fp = fopen($path, 'w');
        fwrite($fp, json_encode($items, JSON_UNESCAPED_UNICODE));
        fclose($fp);
    }

    /**
     * 設定總筆數
     * @return $this 
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getTotalCount()
    {
        return $this->totalCount;
    }
}
