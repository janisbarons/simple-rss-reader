<?php

namespace App\Services\TextAnalyzer;

class WordStatsCalculator
{
    private const SEPARATORS = [
        ' ', "\t", '=', '+', '-', '*', '/',
        '\\', ',', '.', ';', ':', '[', ']',
        '{', '}', '(', ')', '<', '>', '&',
        '%', '$', '@', '#', '^', '!', '?', '~', '…'
    ];

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $commonWords;

    /**
     * @var array $words
     */
    private $words;

    /**
     * WordStatsCalculator constructor.
     * @param array $commonWords
     */
    public function __construct(array $commonWords = [])
    {
        $this->commonWords = $commonWords;
    }

    /**
     * @param string $text
     * @param int $top
     * @return array
     */
    public function wordFrequency(string $text, $top = 10): array
    {
        $this->text = $text;

        $this->splitTextIntoWords();

        if (!empty($this->commonWords)) {
            $this->excludeWords();
        }

        return array_slice($this->getCountOfEachWord(), 0, $top);
    }

    /**
     * @return void
     */
    private function splitTextIntoWords(): void
    {
        $this->prepareText();
        /**
         * str_word_count second parameter means that we are making array
         * @link https://php.net/manual/en/function.str-word-count.php
         */
        $this->words = str_word_count($this->text, 1);

        arsort($this->words);
    }

    /**
     * @return void
     */
    private function excludeWords(): void
    {
        $this->words = array_diff($this->words, $this->commonWords);
    }

    /**
     * @return void
     */
    private function prepareText(): void
    {
        $this->text = strtolower($this->text);
        $this->text = strip_tags($this->text);
        $this->text = str_replace(self::SEPARATORS, ' ', $this->text);
    }

    /**
     * @return array
     */
    private function getCountOfEachWord(): array
    {
        $wordCount = array_count_values($this->words);
        arsort($wordCount);
        return $wordCount;
    }
}
