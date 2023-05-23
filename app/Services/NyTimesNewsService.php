<?php

namespace App\Services;

use App\Interfaces\NewsTransformInterface;

class NyTimesNewsService extends NewsService implements NewsTransformInterface
{

    private String $search;

    public function __construct(String $search)
    {
        parent::__construct("https://api.nytimes.com/svc/search/v2/articlesearch.json", [
            'api-key' => env('NYTIMES_API_KEY'),
            'q' => $search,
            'page-size' => '10',
        ]);
        $this->search = $search;
    }
    public function transformNews(): array
    {
        $response = $this->getNews($this->search);
        $results = $response['response']['docs'];
        $news = collect($results)->map(fn ($result) => [
            "title" => $result['headline']['main'],
            "body" => $result['lead_paragraph'],
            "thumbnail" => $result['multimedia'] && $result['multimedia'][0] ? 'https://www.nytimes.com/' . $result['multimedia'][0]['url'] : null,
            "author" => 'The New York Times',
            "date" => $result['pub_date'],
            "category" => $result['news_desk'],
            "source" => 'The New York Times'
        ]);
        return $news->toArray();
    }
}
