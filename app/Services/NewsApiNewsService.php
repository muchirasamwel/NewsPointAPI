<?php

namespace App\Services;

use App\Interfaces\NewsTransformInterface;
use Ramsey\Uuid\Type\Integer;

class NewsApiNewsService extends NewsService implements NewsTransformInterface
{

    private String $search;

    private $count = 0;

    public function __construct(String $search, array $sources = [])
    {
        parent::__construct("https://newsapi.org/v2/everything", [
            "apiKey" => env("NEWSAPI_API_KEY"),
            "q" => $search,
            "searchIn" => "title,content",
            "sortBy" => "publishedAt",
            "sources" => join(',', $sources),
            "pageSize" => "20",
        ]);
        $this->search = $search;
    }
    public function transformNews(): array
    {
        $response = $this->getNews($this->search);
        $results = $response["articles"];

        $news = collect($results)->map(function ($result) {
            $this->count += 1;
            return [
                "id" => $this->count . 'a',
                "title" => $result["title"],
                "body" => $result["content"],
                "thumbnail" => $result["urlToImage"],
                "author" => $result["author"],
                "date" => $result["publishedAt"],
                "category" => null,
                "source" => $result["source"] ? $result["source"]["name"] : null
            ];
        });
        return $news->toArray();
    }
}
