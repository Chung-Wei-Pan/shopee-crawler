<?php

namespace crawler\shopee\includes;

require_once 'lib/ZhConversion.php';

use MediaWiki\Languages\Data\ZhConversion;

class ZhTranslation
{
    const TRANSLATE_TRAD_TO_SIMP = "tradToSimp";
    const TRANSLATE_SIMP_TO_TRAD = "simpToTrad";
    private $zh2Hant, $zh2Hans;

    public function __construct()
    {
        $this->zh2Hant = ZhConversion::$zh2Hant;
        $this->zh2Hans = ZhConversion::$zh2Hans;
    }

    public function tradToSimp($string)
    {
        return strtr($string, $this->zh2Hans);
    }

    public function simpToTrad($string)
    {
        return strtr($string, $this->zh2Hant);
    }

    public function __call($string, $arguments)
    {
        $title = implode('', $arguments);
        return $title;
    }
}
