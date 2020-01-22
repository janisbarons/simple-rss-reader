<?php
namespace App\Services\FeedReader;

use App\Services\FeedReader\Contracts\ConfigInterface;

class FeedConfig implements ConfigInterface
{
    private const DEFAULT_LIMIT = 5;
    private const DEFAULT_TTL_SECONDS = 3600;
    private const DEFAULT_URL = '';
    /**
     * @var array
     */
    private $config;

    /**
     * FeedConfig constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->config['url'] ?? self::DEFAULT_URL;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->config['ttl'] ?? self::DEFAULT_TTL_SECONDS;
    }

    /**
     * @return int
     */
    public function getLimit():int
    {
        return $this->config['limit'] ?? self::DEFAULT_LIMIT;
    }
}
