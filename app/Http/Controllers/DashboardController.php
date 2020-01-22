<?php

namespace App\Http\Controllers;

use App\Services\FeedReader\Exceptions\ConfigNotSetException;
use App\Services\FeedReader\RssReader;
use App\Services\TextAnalyzer\WordStatsCalculator;
use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    public const COMMON_WORDS_CSV_STORAGE_PATH = 'data/commonWords.csv';
    public const RSS_CHANNEL = 'theregister';
    public const STATS_CACHE_KEY = 'word-statistics';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     * @throws ConfigNotSetException
     * @throws \Exception
     */
    public function __invoke(): Renderable
    {
        $reader = (new RssReader())
            ->setConfig(self::RSS_CHANNEL)
            ->read();

        return view('dashboard', [
            'items' => $reader->getItems()->paginate(),
            'stats' => $this->getWordStatistics($reader)
        ]);
    }

    /**
     * @return array
     */
    private function getCommonWords(): array
    {
        $commonWords = array_map('str_getcsv', file(storage_path(self::COMMON_WORDS_CSV_STORAGE_PATH)));

        return \Arr::flatten($commonWords);
    }

    /**
     * @param RssReader $reader
     * @return array
     * @throws \Exception
     */
    private function getWordStatistics(RssReader $reader): array
    {
        return cache()->remember(
            self::STATS_CACHE_KEY,
            $reader->getConfig()->getTtl(),
            function () use ($reader) {
                $commonWords = $this->getCommonWords();

                return (new WordStatsCalculator($commonWords))
                ->wordFrequency(
                    $reader->getFullText()
                );
            }
        );
    }
}
