<?php

namespace crawler\shopee\includes;

class UrlArgs
{
    protected $limit, $newest;
    protected $args = [];

    public function __construct($limit, $newest)
    {
        $this->limit = $limit;
        $this->newest = $newest;
    }

    public function setArgs()
    {
        $this->args = [
            'limit' => $this->limit,
            'newest' => $this->newest,
        ];
        return $this;
    }

    public function getArgs()
    {
        return $this->args;
    }
}
