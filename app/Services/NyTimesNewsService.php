<?php

namespace App\Services;

use App\Interfaces\NewsTransformInterface;

class NyTimesNewsService extends NewsService implements NewsTransformInterface
{

    private String $search;
    private $count = 0;

    public function __construct(String $search)
    {
        parent::__construct(env('NYTIMES_NEWS_URL'), [
            "api-key" => env("NYTIMES_API_KEY"),
            "q" => $search,
            "sort" => "newest",
            "page-size" => "10",
        ]);
        $this->search = $search;
    }
    public function transformNews(): array
    {
        $response = $this->getNews($this->search);
        $results = $response["response"]["docs"];
        $news = collect($results)->map(function ($result) {
            $this->count += 1;
            return  [
                "id" => $this->count . 'n',
                "title" => $result["headline"]["main"],
                "body" => $result["lead_paragraph"],
                "thumbnail" => $result["multimedia"] && $result["multimedia"][0] ? "https://www.nytimes.com/" . $result["multimedia"][0]["url"] : null,
                "author" => "The New York Times",
                "date" => $result["pub_date"],
                "category" => array_key_exists('news_desk', $result) ? $result["news_desk"] : null,
                "source" => "New York Times News"
            ];
        });
        return $news->toArray();
    }
}
