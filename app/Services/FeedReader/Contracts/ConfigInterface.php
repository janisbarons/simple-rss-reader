<?php
namespace App\Services\FeedReader\Contracts;

interface ConfigInterface
{
    public function getUrl():string;
    public function getTtl():int;//seconds
    public function getLimit():int;
}
