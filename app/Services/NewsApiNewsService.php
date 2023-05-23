<?php

namespace App\Services;

use App\Interfaces\NewsTransformInterface;

class NewsApiNewsService extends NewsService implements NewsTransformInterface
{

    private String $search;

    public function __construct(String $search, array $sources = [])
    {
        parent::__construct("https://newsapi.org/v2/everything", [
            "apiKey" => env("NEWSAPI_API_KEY"),
            "q" => $search,
            "searchIn" => "title,content",
            "sortBy" => "publishedAt",
            "sources" => join(',', $sources),
            "pageSize" => "15",
        ]);
        $this->search = $search;
    }
    public function transformNews(): array
    {
        $response = $this->getNews($this->search);
        $results = $response["articles"];

        $news = collect($results)->map(fn ($result) => [
            "title" => $result["title"],
            "body" => $result["content"],
            "thumbnail" => $result["urlToImage"],
            "author" => $result["author"],
            "date" => $result["publishedAt"],
            "category" => null,
            "source" => $result["source"] ? $result["source"]["name"] : null
        ]);
        return $news->toArray();
    }
}
