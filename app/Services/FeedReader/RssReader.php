<?php
namespace App\Services\FeedReader;

use App\Services\FeedReader\Contracts\ConfigInterface;
use App\Services\FeedReader\Exceptions\ConfigNotSetException;

class RssReader
{
    /**
     * @var ItemsCollection
     */
    private $items;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * Get feed service config.
     *
     * @param string $serviceName
     * @return RssReader
     */
    public function setConfig(string $serviceName): RssReader
    {
        $this->config =  new FeedConfig(
            config(sprintf('feeds.channels.%s', $serviceName), [])
        );

        return $this;
    }

    /**
     * @return ItemsCollection
     */
    public function getItems(): ItemsCollection
    {
        return $this->items;
    }

    /**
     * @return RssReader
     * @throws ConfigNotSetException
     */
    public function read(): RssReader
    {
        if (empty($this->config)) {
            throw new ConfigNotSetException('Config is not set');
        }
        /** @var \SimplePie $feed */
        $feed = \Feeds::make(
            $this->config->getUrl(),
            $this->config->getLimit(),
            true
        );

        $this->title = $feed->get_title();
        $this->permalink = $feed->get_permalink();
        $this->items = new ItemsCollection($feed->get_items());

        return $this;
    }

    /**
     * @return string
     */
    public function getFullText(): string
    {
        return $this->getItems()->map(static function (\SimplePie_Item $item) {
            return [
                'get_description' => $item->get_description()
            ];
        })->implode('get_description', ' ');
    }

    /**
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }
}
