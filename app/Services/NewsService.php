<?php

namespace App\Services;

use App\Interfaces\NewsFetchInterface;
use GuzzleHttp\Client;

/**
 * Used for the fetch of any news from any of the three apis
 * The guardian news,
 * NyTimes news and
 * newsapi.org
 */

class NewsService implements NewsFetchInterface
{
    private $URL;
    private $query;
    public function __construct(String $URL, array $query)
    {
        $this->URL = $URL;
        $this->query = $query;
    }

    public function getNews(String $search): array
    {
        $client = new Client();
        $resp =  $client->get($this->URL, [
            'query' => $this->query,
        ]);

        return json_decode($resp->getBody(), true);
    }
}
