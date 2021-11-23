<?php

namespace crawler\shopee\includes;

use Exception;

class CrawlerFunction
{
    const ALLOWED_HTTP_METHOD_GET = "GET";
    const ALLOWED_HTTP_METHOD_POST = "POST";
    private $targetUrl;
    private static $response = [];

    /**
     * @param string $targetUrl 要爬的網站
     * @param array|null $args 網址後要帶的參數
     */
    public function __construct($targetUrl)
    {
        $this->targetUrl = $targetUrl;
    }

    public function start($method, $args = null)
    {
        $httpMethod = [
            self::ALLOWED_HTTP_METHOD_GET, self::ALLOWED_HTTP_METHOD_POST
        ];
        if (!in_array($method, $httpMethod)) {
            throw new Exception("HTTP Method Not Allowed", 405);
        }
        $url = $this->targetUrl . "?" . http_build_query($args);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            // CURLOPT_POSTFIELDS => $query,
            CURLOPT_HTTPHEADER => array(
                'Connection: keep-alive',
                'Pragma: no-cache',
                'Cache-Control: no-cache',
                'Upgrade-Insecure-Requests: 1',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Sec-Fetch-Site: none',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-Dest: document',
                'Accept-Language: zh-TW,zh-CN;q=0.9,zh;q=0.8,en-US;q=0.7,en;q=0.6',
            ),
        ));
        $this->response = json_decode(curl_exec($curl), true);

        curl_close($curl);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getTargetUrl()
    {
        return $this->targetUrl;
    }
}
